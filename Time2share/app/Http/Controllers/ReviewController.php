<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\PendingReturn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function newReviewForm(Product $product): View
    {
        return view('profile.newReview', ['product' => $product]);
    }

    public function store(Product $product, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|string',
            'description' => 'sometimes|string',
            'rating' => 'sometimes|integer|max:10'
        ]);

        $validated['product_id'] = $product->id;
        $validated['reviewer_id'] = $request->user()->id;
        $validated['reviewLoaner_id'] = $product->loaner_id;
        
        Review::create($validated);

        $this->acceptProductReturn($product);

        return redirect()->route('products.overview');
    }

    public function acceptProductReturn(Product $product)
    {
        
        if($product->loaned_out){
            $product->update([
                'loaner_id' => null,
                'loaned_out' => 0
            ]);
        }

        $pendingReturn = PendingReturn::where('product', $product->id);
        $pendingReturn->delete();
    }

    public function showReviews(Request $request): View
    {
        $userId = $request->user()->id;
        $filter = $request->input('filter');
        $sortRating = $request->input('sortRating');
        $sortDate = $request->input('sortDate');

        $reviews = collect(); 

        switch ($filter) {
            case 'sentReviews': // Uitgeleende producten
                $reviews = Review::with('reviewer', 'reviewloaner', 'product')
                ->where('reviewer_id', $userId)
                ->latest()
                ->get();
                break;
    
            case 'receivedReviews': // Lenende producten
                $reviews = Review::with('reviewer', 'reviewloaner', 'product')
                ->where('reviewLoaner_id', $userId)
                ->latest()
                ->get();
                break;
   
            default: // Geen filter: toon alles
                $reviews = Review::with('reviewer', 'reviewloaner', 'product')
                ->where('reviewer_id', $userId)
                ->latest()
                ->get();
                break;
        }

        switch ($sortRating){
            case 'lowToHigh': // Lenende producten
                $reviews = Review::with('reviewer', 'reviewloaner', 'product')
                ->orderByRaw('rating ASC')
                ->get();
                break;

            case 'highToLow': // Lenende producten
                $reviews = Review::with('reviewer', 'reviewloaner', 'product')
                ->orderByRaw('rating DESC')
                ->get();
                break;     
        }

        switch ($sortDate){
            case 'oldFirst': // Lenende producten
                $reviews = Review::with('reviewer', 'reviewloaner', 'product')
                ->orderByRaw('created_at ASC')
                ->get();
                break;

            case 'newFirst': // Lenende producten
                $reviews = Review::with('reviewer', 'reviewloaner', 'product')
                ->orderByRaw('created_at DESC')
                ->get();
                break; 

        }


        return view('profile.reviews', [
            'reviews' => $reviews,
            'filter' => $filter,
            'sortRating' => $sortRating,
            'sortDate' => $sortDate
        ]);
    }
}

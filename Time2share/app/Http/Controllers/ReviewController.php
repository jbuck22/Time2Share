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
        $pendingReturn = PendingReturn::where('product', $product->id)->first();

        return view('profile.newReview', ['product' => $product, 'pendingReturn' => $pendingReturn]);
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

        $query = Review::with('reviewer', 'reviewloaner', 'product');


        if ($filter === 'sentReviews') {
            $query->where('reviewer_id', $userId);
        } elseif ($filter === 'receivedReviews') {
            $query->where('reviewLoaner_id', $userId);
        } else {
            $query->where('reviewer_id', $userId); // Toon standaard 'sentReviews'
        }
    
        // Pas de sorteervolgorde toe
        if ($sortRating === 'lowToHigh') {
            $query->orderBy('rating', 'asc');
        } elseif ($sortRating === 'highToLow') {
            $query->orderBy('rating', 'desc');
        }
    
        if ($sortDate === 'oldFirst') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sortDate === 'newFirst') {
            $query->orderBy('created_at', 'desc');
        }
    
        // Voer de query uit
        $reviews = $query->get();
    
        return view('profile.reviews', [
            'reviews' => $reviews,
            'filter' => $filter,
            'sortRating' => $sortRating,
            'sortDate' => $sortDate
        ]);
    }
}

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

        return redirect()->route('products.accept', $product);
    }
}

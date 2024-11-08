<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PendingReturn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class PendingReturnController extends Controller
{
    public function showPendingReturns(Request $request): View
    {
        $products = Product::with('owner', 'loaner')->where('owner_id', $request->user()->id)->latest()->get();

        $loanedProducts = Product::with('owner', 'loaner')->where('loaner_id', $request->user()->id)->latest()->get();

        $pendingReturns = PendingReturn::pluck('product')->toArray();  


        return view('products.overview', [
            'products' => $products,
            'loanedProducts' => $loanedProducts,
            'pendingReturns' => $pendingReturns
   
        ]);
    }

    public function returningProduct(Request $request, Product $loanedProduct): RedirectResponse
    {   

        $validated = $request->validate([
            'owner_id' => 'required|integer',
            'loaner_id' => 'nullable|integer'
        ]);
        
        $validated['product'] = $loanedProduct->id;
        $validated['owner_id'] = $loanedProduct->owner_id;
        $validated['loaner_id'] = $loanedProduct->loaner_id;

        PendingReturn::create($validated);

        return redirect(route('products.index'));
    }
}

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

        // $pendingReturns = PendingReturn::where('product', $products->id)->latest()->get();  


        return view('products.overview', [
            'products' => $products,
            'loanedProducts' => $loanedProducts
   
        ]);
    }

    public function returningProduct(Request $request, Product $loanedProduct): RedirectResponse
    {   
        // dd($loanedProduct);
        // dd($request);

        $validated = $request->validate([
            'owner_id' => 'required|integer',
            'loaner_id' => 'nullable|integer'
        ]);
        
        
        // Voeg het product_id toe aan de gevalideerde gegevens
        $validated['product'] = $loanedProduct->id;
        $validated['owner_id'] = $loanedProduct->owner_id;
        $validated['loaner_id'] = $loanedProduct->loaner_id;
    
        

        // Maak de nieuwe pending return aan met de gevalideerde gegevens

        PendingReturn::create($validated);

        // dd($validated);

        return redirect(route('products.overview'));
    }
}

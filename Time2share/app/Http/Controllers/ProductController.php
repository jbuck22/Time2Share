<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {

        $search = $request->input('search');
        $products = Product::with('owner', 'loaner')->where('loaned_out', 0)->when($search, function ($query, $search) 
            {
                return $query->where('description', 'like', "%{$search}%")->orWhere('category', 'like', "%{$search}%");
            })->latest()->get();

            return view('products.index', 
            [
                'products' => $products,
            ]);
    }



    public function productReturned(Request $request): RedirectResponse
    {
        $product = Product::where('id', $request->id);
        
        $product->update([
            'loaner_id' => null,
            'loaned_out' => 0
        ]);

        // $product->loaned_out = 0;
        // $product->loaner_id = null;
        // $product->save();
        return redirect()->back();
    }

    public function productLoaned(Request $request, Product $product): RedirectResponse
    {
        $product->loaned_out = 1;
        $product->loaner_id = $request->user()->id;
        $product->save();
        
        return redirect()->route('products.index')->with('success', 'Product successfully loaned.');
    }

    public function showLoanForm(Product $product): View
    {
        return view('products.loan', ['product' => $product]);
    }


    public function store(Request $request): RedirectResponse
    { 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'deadline' => 'required|date',
        ]);
    
        // Voeg de 'owner_id' handmatig toe aan de data array
        $validated['owner_id'] = $request->user()->id;
    
        // Sla het product op met de extra 'owner_id'
        Product::create($validated);
    
        return redirect(route('products.index'))->with('success', 'product succesvol aangemaakt');
    }  

    public function newproduct(): View
    {
        return view('products.newproduct');
    }
}
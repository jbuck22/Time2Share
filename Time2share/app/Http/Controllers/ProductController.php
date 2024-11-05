<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::with('owner', 'loaner')->latest()->get(),
        ]);
    }

    public function newproduct(): View
    {
        return view('products.newproduct');
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



    // public function store(Request $request): RedirectResponse
    // {
    //     $validated = $request->validate([
    //         'message' => 'required|string|max:255',
    //     ]);

    //     $request->user()->products()->create($validated);
    //     return redirect(route('products.index'));
    // }
}
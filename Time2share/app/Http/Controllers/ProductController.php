<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PendingReturn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function showDashboard(Request $request): View
    {

        $search = $request->input('search');
        $products = Product::with('owner', 'loaner')->where('loaned_out', 0)->when($search, function ($query, $search) 
            {
                return $query->where('description', 'like', "%{$search}%")->orWhere('category', 'like', "%{$search}%")->orWhere('name', 'like', "%{$search}%");
            })->latest()->get();

            return view('dashboard', 
            [
                'products' => $products,
            ]);
    }

    public function productReturned(Request $request): RedirectResponse
    {
        $product = Product::where('id', $request->product)->first();
        
        $product->update([
            'loaner_id' => null,
            'loaned_out' => 0
        ]);

        $pendingReturn = PendingReturn::where('product', $product->id);
        $pendingReturn->delete();
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
        
        return redirect()->route('dashboard')->with('success', 'Product successfully loaned.');
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
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validated['image'] = $imagePath;
        } else {
            $validated['image'] = null;
        }
    
        // Voeg de 'owner_id' handmatig toe aan de data array
        $validated['owner_id'] = $request->user()->id;
        // Sla het product op met de extra 'owner_id'
        Product::create($validated);
    
        return redirect(route('products.showDashboard'))->with('success', 'product succesvol aangemaakt');
    }  

    public function newproduct(): View
    {
        return view('products.newproduct');
    }

    public function deleteProduct(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->back()->with('status', 'Product deleted succesfully');
    }
}
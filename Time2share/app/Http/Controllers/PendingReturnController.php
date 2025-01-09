<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\PendingReturn;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\View\View;
use Psy\Command\WhereamiCommand;
use Illuminate\Validation\ValidationException;

class PendingReturnController extends Controller
{
    public function showPendingReturns(Request $request): View
    {
        $userId = $request->user()->id;
        $filter = $request->input('filter'); 

        
    
        $products = collect();
        $pendingReturns = PendingReturn::pluck('product')->toArray();  

        switch ($filter) {
            case 'loaned':
                $products = Product::with('owner', 'loaner')
                    ->where('owner_id', $userId)
                    ->where('loaned_out', 1)
                    ->latest()
                    ->get();
                break;
    
            case 'loaning':
                $products = Product::with('owner', 'loaner')
                    ->where('loaner_id', $userId)
                    ->latest()
                    ->get();
                break;
    
            case 'pending_returns':
                $products = Product::with('owner', 'loaner')
                    ->where('owner_id', $userId)
                    ->whereIn('id', $pendingReturns)
                    ->latest()
                    ->get();
                break;
    
            case 'my_products':
                $products = Product::with('owner', 'loaner')
                    ->where('owner_id', $userId)
                    ->orWhere('loaner_id', $userId)
                    ->latest()
                    ->get();
                break;

            default: 
                $products = Product::with('owner', 'loaner')
                    ->where('owner_id', $userId)
                    ->where('loaner_id', $userId)
                    ->latest()
                    ->get();
                break;
        }


        return view('products.overview', [
            'products' => $products,
            'filter' => $filter, 
            'pendingReturns' => $pendingReturns,
        ]);
    }


    public function returningProduct(Request $request): RedirectResponse
    {   

        $product = Product::where('id', $request->product)->first();
        
        $validated = $request->validate([
            'owner_id' => 'sometimes|nullable|integer', 
            'loaner_id' => 'sometimes|nullable|integer',
        ]);

        $validated['product'] = $product->id;
        $validated['owner_id'] = $product->owner_id;
        $validated['loaner_id'] = $product->loaner_id;


        PendingReturn::create($validated);

        return redirect()->back();
    }
}

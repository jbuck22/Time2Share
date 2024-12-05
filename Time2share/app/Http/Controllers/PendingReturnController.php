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

class PendingReturnController extends Controller
{
    public function showPendingReturns(Request $request): View
    {
        $userId = $request->user()->id;
        $filter = $request->input('filter'); // Ontvang de filteroptie uit de querystring

        
    
        $products = collect();
        $pendingReturns = PendingReturn::pluck('product')->toArray();  

        switch ($filter) {
            case 'loaned': // Uitgeleende producten
                $products = Product::with('owner', 'loaner')
                    ->where('owner_id', $userId)
                    ->where('loaned_out', 1)
                    ->latest()
                    ->get();
                break;
    
            case 'loaning': // Lenende producten
                $products = Product::with('owner', 'loaner')
                    ->where('loaner_id', $userId)
                    ->latest()
                    ->get();
                break;
    
            case 'pending_returns': // Producten die terug zijn
                $products = Product::with('owner', 'loaner')
                    ->where('owner_id', $userId)
                    ->whereIn('id', $pendingReturns) // Bijv. een 'returned' kolom
                    ->latest()
                    ->get();
                break;
    
            default: // Geen filter: toon alles
                $products = Product::with('owner', 'loaner')
                    ->where('owner_id', $userId)
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

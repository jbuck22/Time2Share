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
        $userId = $request->user()->id;
        $filter = $request->input('filter'); // Ontvang de filteroptie uit de querystring
    
        // Basisquery voor producten van de gebruiker
        $productsQuery = Product::with('owner', 'loaner')
            ->where('owner_id', $userId);
    
        $loanedProductsQuery = Product::with('owner', 'loaner')
            ->where('loaner_id', $userId);
    
            // Pending returns ophalen
        $pendingReturns = PendingReturn::pluck('product')->toArray();

        // Filter toepassen op basis van de geselecteerde optie
        switch ($filter) {
            case 'loaned': // Uitgeleende producten
                $productsQuery->where('loaned_out', 1);
                break;
    
            case 'loaning': // Lenende producten
                $loanedProductsQuery->where('loaner_id', $userId);
                break;
    
            case 'returned': // Producten die terug zijn
                $productsQuery->in_array($productsQuery->id, $pendingReturns); // Voorbeeld: je hebt een `returned`-kolom
                break;
    
            default:
                break;
        }
    
        // Query’s uitvoeren
        $products = $productsQuery->latest()->get();
        $loanedProducts = $loanedProductsQuery->latest()->get();
    
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

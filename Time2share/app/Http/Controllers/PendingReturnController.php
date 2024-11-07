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

        // $pendingReturns = PendingReturn::where('product', $products->id)->latest()->get();  


        return view('dashboard', [
            'products' => $products,
            // 'pendingReturns'=> $pendingReturns   
        ]);
    }

    public function setPending(Request $request): RedirectResponse
    {
        return redirect()->back();
    }
}

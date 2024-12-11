<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Product;
use App\Models\PendingReturn;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class UserController extends Controller
{
    public function blockUser(Product $product): RedirectResponse
    {
        $user = $product->owner;
        $user->update(['blocked' => 1]);
        return redirect()->back()->with('status', 'User blocked succesfully');
    }

    public function unblockUser(Product $product): RedirectResponse
    {
        $user = $product->owner;
        $user->update(['blocked' => 0]);
        return redirect()->back()->with('status', 'User unblocked succesfully');
    }
}   

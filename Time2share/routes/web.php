<?php

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PendingReturnController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {  
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/review', [ReviewController::class, 'showReviews'])->name('profile.reviews');
    
    Route::get('/profile/{product}/newReview', [ReviewController::class, 'newReviewForm'])->name('profile.newReview');
    Route::post('/profile/{product}/saveReview', [ReviewController::class, 'store'])->name('review.store');

    Route::get('/products/new', [ProductController::class, 'newproduct'])->name('products.newproduct');
    Route::get('/products/{product}/loan', [ProductController::class, 'showLoanForm'])->name('products.loanForm');
    Route::post('/products/{product}/loan', [ProductController::class, 'productLoaned'])->name('products.loan');
    Route::get('/products/overview', [PendingReturnController::class, 'showPendingReturns'])->name('products.overview');
    Route::post('/products/{product}/overview', [PendingReturnController::class, 'returningProduct'])->name('products.return');
    Route::patch('/products/{product}/overview', [ProductController::class, 'productReturned'])->name('products.accept');
    
    Route::get('/dashboard', [ProductController::class, 'showDashboard'])->name('products.showDashboard');


});

Route::middleware(['auth', 'blockedCheck', 'verified'])->group(function () {
    Route::get('/profile/blocked', [ProfileController::class, 'showBlocked'])->name('profile.blocked');
});



Route::middleware(['auth', 'adminCheck', 'verified'])->group(function (){
    Route::post('/products/{product}/block', [UserController::class, 'blockUser'])->name('user.block');
    Route::post('/products/{product}/unblock', [UserController::class, 'unblockUser'])->name('user.unblock');
    Route::delete('products/{product}/delete', [ProductController::class, 'deleteProduct'])->name('product.delete');
});


Route::resource('products', ProductController::class)
    ->only(['index', 'store'])
    ->middleware(['auth', 'verified']);


require __DIR__.'/auth.php';

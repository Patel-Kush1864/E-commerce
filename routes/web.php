<?php

use App\Http\Controllers\wishlist;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartitemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RegisterController;
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
    return view('home');
});



// // Define the route for login page
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('Login.login');
// route::post('/login_user',[LoginController::class,'login_user'])->name('Login.login_user');

Route::post('/login', [LoginController::class, 'login_user'])->name('login_user');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('Register.showRegisterForm');
Route::resource('Register',RegisterController::class);

Route::get('/admin_dashboard', function () {
    return view('admin_dashboard');
})->name('admin.dashboard');


Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('Product',ProductController::class);
Route::resource('Category',CategoryController::class);
Route::resource('Cart',CartController::class);
Route::resource('Order',OrderController::class);

Route::get('/cart/heart/{id}', [CartController::class, 'heart'])->name('cart.heart');

Route::get('/cart/addtocart/{id}', [CartController::class, 'addtocart'])->name('cart.addtocart');

Route::get('/wishlist', [CartController::class, 'showWishlist'])->name('wishlist.show');

Route::get('/wishlist/remove/{id}', [CartController::class, 'removeFromWishlist'])->name('wishlist.remove');

Route::get('/cart', [CartController::class, 'showAddToCart'])->name('addtocart.show');

Route::delete('/cart/{id}', [CartController::class, 'removeFromAddToCart'])->name('addtocart.remove');

Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');

Route::post('/cart/delivery', [CartController::class, 'delivery'])->name('Cart.delivery');

Route::get('Order/{id}', [OrderController::class, 'show'])->name('Order.show');

Route::put('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('Order.updateStatus');

Route::get('/orders', [OrderController::class, 'index_user'])->name('Order.index_user');












<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Stripecontroller;
use App\Http\Controllers\customAuthController;
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
// Route::get('/login', [customAuthController::class, 'login'])->name('login');
// Route::get('/registration', [customAuthController::class, 'registration'])->name('registration');


Route::post('/session', [Stripecontroller::class, 'session'])->name('session');
Route::get('/success', [Stripecontroller::class, 'success'])->name('success');
Route::get('/cancel', [Stripecontroller::class, 'cancel'])->name('cancel');
 
 
//Route::get('/', function () {
//    return view('welcome');
//});
 
Route::get('/', [ProductController::class, 'index']);
Route::get('cart', [ProductController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add_to_cart');
Route::patch('update-cart', [ProductController::class, 'update'])->name('update_cart');
Route::delete('remove-from-cart', [ProductController::class, 'remove'])->name('remove_from_cart');

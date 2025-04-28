<?php
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\frontend\PageController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\checkoutController;
use App\Http\Controllers\frontend\BookingController;


use Illuminate\Support\Facades\Route;


Route::controller(HomeController::class)->group(function () {
    Route::get('/', [App\Http\Controllers\frontend\HomeController::class, 'index']); 
});

Route::controller(AboutController::class)->group(function () {
    Route::get('/about', [App\Http\Controllers\frontend\AboutController::class, 'index']); 
});
Route::controller(ServicesController::class)->group(function () {
    Route::get('/services', [App\Http\Controllers\frontend\ServicesController::class, 'index']); 
});
Route::controller(contactController::class)->group(function () {
    Route::get('/contact', [App\Http\Controllers\frontend\ContactController::class, 'index']); 
});
Route::controller(BookingController::class,'index')->group(function () {
    Route::get('/page', [App\Http\Controllers\frontend\PagesController::class, 'index']); 
});

Route::get('/products', [\App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('products.index');
Route::get('/booking', [\App\Http\Controllers\frontend\BookingController::class, 'index'])->name('frontend.booking.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('frontend.cart.add');
Route::get('/checkout', [\App\Http\Controllers\frontend\CheckoutController::class, 'index'])->name('checkout');




//backend
Route::controller(BDashboardController::class)->group(function () {
Route::get('/admin/dashboard', [BDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/products', [BDashboardController::class, 'products'])->name('admin.products');
    Route::get('/admin/products/create', [BDashboardController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [BDashboardController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{id}/edit', [BDashboardController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{id}', [BDashboardController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [BDashboardController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/orders', [BDashboardController::class, 'orders'])->name('admin.orders');
});










    
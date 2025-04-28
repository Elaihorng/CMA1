<?php
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\frontend\PageController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\OrderController;
use App\Http\Controllers\frontend\BookingController;
use App\Http\Controllers\backend\BBookingController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\backend\BDashboardController;
use App\Http\Controllers\backend\BProductController;
use App\Http\Controllers\backend\BReviewController;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\frontend\ReviewController;
use App\Http\Controllers\backend\BOrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\backend\PaywayController;
use App\Http\Controllers\StripeController;

use App\Services\AbaPayWayService;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(AboutController::class)->group(function () {
    Route::get('/about', [App\Http\Controllers\frontend\AboutController::class, 'index']); 
});
Route::controller(ServicesController::class)->group(function () {
    Route::get('/services', [App\Http\Controllers\frontend\ServicesController::class, 'index']); 
});
Route::controller(contactController::class)->group(function () {
    Route::get('/contact', [App\Http\Controllers\frontend\ContactController::class, 'index']); 
});
// Route::controller(PagesController::class)->group(function () {
//     Route::get('/page', [App\Http\Controllers\frontend\PagesController::class, 'index']); 
// });
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('frontend.orders.index');
});

Route::match(['post','get'],'/products', [\App\Http\Controllers\Frontend\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [\App\Http\Controllers\Frontend\ProductController::class, 'show'])->name('products.show');
Route::get('/cart', [\App\Http\Controllers\Frontend\CartController::class, 'index'])->name('frontend.cart.index');
Route::post('/cart/add', [\App\Http\Controllers\Frontend\CartController::class, 'add'])->name('frontend.cart.add');
Route::post('/cart/update/{product_id}', [\App\Http\Controllers\Frontend\CartController::class, 'update'])->name('frontend.cart.update');
Route::post('/cart/remove/{id}', [\App\Http\Controllers\Frontend\CartController::class, 'remove'])->name('frontend.cart.remove');
Route::get('/orders', [OrderController::class, 'index'])->name('frontend.orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('frontend.orders.show');
Route::get('/orders', [OrderController::class, 'index'])->name('frontend.orders.index');
Route::get('/checkout', [\App\Http\Controllers\frontend\CheckoutController::class, 'index'])->name('frontend.checkout.index');
Route::post('checkout/process', [CheckoutController::class, 'process'])->name('frontend.checkout.process');
Route::middleware(['auth'])->group(function () {
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/booking/show/{id}', [BookingController::class, 'show'])->name('booking.show'); 
    Route::get('/booking/details{id}', [BookingController::class, 'details'])->name('booking.details'); 
});

Route::controller(AuthController::class)->group(function() {
    Route::get('/login', 'index')->name('login');
    Route::get('/register', 'register')->name('register');
    Route::post('/register.save', 'saveRegister')->name('register.save');
    Route::post('/login', 'loginAction')->name('login.action');
});
Route::post('/booking', [BookingController::class, 'store'])->name('frontend.booking.store');





//backend
Route::controller(BDashboardController::class)->group(function(){
    Route::get('/dashboard','index')->name('dashboard.index');
});
// Route::middleware('auth')->get('/dashboard', [BDashboardController::class, 'index'])->name('dashboard.index');
Route::middleware(['auth'])->group(function () {
    Route::get('user', [\App\Http\Controllers\backend\AuthController::class, 'showUsers'])->name('index');
    Route::get('/user/create', [AuthController::class, 'createUserForm'])->name('user.create');
    Route::post('/user/create', [AuthController::class, 'createUser'])->name('user.store');
    Route::get('user/{id}/edit', [AuthController::class, 'edit'])->name('user.edit');
    Route::put('user/{id}', [AuthController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [AuthController::class, 'destroy'])->name('user.destroy');

});

Route::post('/logout', function () {
    Auth::logout();  
    session()->forget('username');  
    session()->invalidate();        
    session()->regenerateToken();   

    return redirect()->route('login');  
})->name('logout');

Route::resource('/product', BProductController::class);

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('bookings', BBookingController::class);
    Route::patch('bookings/{id}/confirm', [BBookingController::class, 'confirm'])->name('bookings.confirm');
});

Route::get('order', [BOrderController::class, 'index'])->name('orderPlace.index');
Route::get('order/{id}', [BOrderController::class, 'show'])->name('backend.orderPlace.show');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/review', [BReviewController::class, 'index'])->name('review.index');

Route::post('orders/{order}/mark-as-paid', [BOrderController::class, 'markAsPaid'])->name('backend.orders.markAsPaid');

Route::get('/checkout/success', function () {
    return view('frontend.checkout.success');
})->name('frontend.checkout.success');
Route::patch('/admin/orders/{id}/confirm', [BOrderController::class, 'confirm'])->name('backend.orderPlace.confirm');
Route::patch('/admin/orders/{id}/cancel', [BOrderController::class, 'cancel'])->name('backend.orderPlace.cancel');
Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('otp.form');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');

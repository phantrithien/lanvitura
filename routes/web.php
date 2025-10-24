<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
// Admin Controllers
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
// Frontend Controllers
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\UserOrderController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\AddressController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\BlogController;




// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [FrontendProductController::class, 'show'])->name('products.show');
Route::get('/products/{product:slug}', [FrontendProductController::class, 'show'])->name('products.show');

Route::get('/search', [FrontendProductController::class, 'search'])->name('products.search');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{rowId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Static Pages
Route::get('/about', [PageController::class, 'about'])->name('about');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');


// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('post-categories', PostCategoryController::class);
    Route::resource('users', UserController::class);
    Route::resource('tags', TagController::class); // Giữ lại dòng này

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::delete('/product-images/{productImage}', [ProductImageController::class, 'destroy'])->name('product-images.destroy');

    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
    Route::delete('/contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');

    // --- THÊM CÁC ROUTE CHO REVIEW ---
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}', [AdminReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/order-success', [CheckoutController::class, 'success'])->name('checkout.success');

    Route::get('/my-orders', [UserOrderController::class, 'index'])->name('user.orders.index');
    Route::get('/my-orders/{order}', [UserOrderController::class, 'show'])->name('user.orders.show');

    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::resource('addresses', AddressController::class);
});

require __DIR__ . '/auth.php';
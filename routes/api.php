<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\socialAuthController;
use App\Http\Controllers\Api\BookingCourtController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CouchController;
use App\Http\Controllers\Api\CourtController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\TrainingProgramController;
use App\Http\Controllers\Api\TrainingSubscriptionController;
use App\Http\Controllers\Api\SportTypeController;
use App\Http\Controllers\Api\TimeController;

/*
|--------------------------------------------------------------------------
| Public API (NO AUTH)
|--------------------------------------------------------------------------
*/

Route::middleware(['setLocale'])->group(function () {


  // Social Auth
  Route::get('/login-google', [socialAuthController::class, 'redirectToProvider']);
  Route::get('/auth/google/callback', [socialAuthController::class, 'handleCallback']);

  // Contact & Password
  Route::post('contact-us', [ContactController::class, 'send'])->middleware('throttle:5,1');
  Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
  Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);

  // Auth
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);

  // Categories
  Route::get('categories', [CategoryController::class, 'index']);
  Route::get('categories/{category}', [CategoryController::class, 'show']);

  // Products
  Route::get('products', [ProductController::class, 'index']);
  Route::get('products/featured', [ProductController::class, 'featured']);
  Route::get('products/{product}', [ProductController::class, 'show']);
  Route::get('products-sliders', [ProductController::class, 'sliders']);

  // Product Variants
  Route::get('product-variants', [ProductVariantController::class, 'index']);
  Route::get('product-variants/{product_variant}', [ProductVariantController::class, 'show']);
  Route::get('variants-sliders', [ProductVariantController::class, 'slidersVariants']);
  Route::get('variants-category/{name}', [ProductVariantController::class, 'byVariantsCategoryName']);

  // colors
  Route::get('colors', [ColorController::class, 'index']);
  // sizes
  Route::get('sizes', [SizeController::class, 'index']);

  Route::get('courts', [CourtController::class, 'index']);
  Route::get('courts/{court}', [CourtController::class, 'show']);

  // Couches
  Route::get('couches', [CouchController::class, 'index']);
  Route::get('couches/{couch}', [CouchController::class, 'show']);

  // Training Programs
  Route::get('training-programs', [TrainingProgramController::class, 'index']);
  Route::get('training-programs/{training_program}', [TrainingProgramController::class, 'show']);

  Route::get('subscriptions', [TrainingSubscriptionController::class, 'index']);

  // Sport Types
  Route::get('sport-types', [SportTypeController::class, 'index']);
  Route::get('sport-types/{sport_type}', [SportTypeController::class, 'show']);

  // Times
  Route::get('times', [TimeController::class, 'index']);
  Route::get('times/{time}', [TimeController::class, 'show']);

  Route::get('bookings/available-times', [BookingCourtController::class, 'getAvailableTimes']);
});


/*
|--------------------------------------------------------------------------
| Authenticated User API
|--------------------------------------------------------------------------
*/
Route::middleware(['setLocale', 'auth:sanctum'])->group(function () {

  // User
  Route::get('me', [AuthController::class, 'me']);
  Route::put('profile', [AuthController::class, 'updateProfile']);
  Route::post('logout', [AuthController::class, 'logout']);
  Route::post('subscriptions', [TrainingSubscriptionController::class, 'store']);
  Route::get('my-subscriptions', [TrainingSubscriptionController::class, 'index']);

  // Cart
  Route::get('/cart', [CartController::class, 'index']);
  Route::post('/cart', [CartController::class, 'store']);
  Route::put('/cart/{id}', [CartController::class, 'update']);
  Route::delete('/cart/{id}', [CartController::class, 'destroy']);
  Route::delete('/cart-clear', [CartController::class, 'clear']);

  Route::get('/orders', [OrderController::class, 'index']);
  Route::post('/orders', [OrderController::class, 'store']);
  Route::delete('/orders/{id}', [OrderController::class, 'destroy']);


  Route::post('bookings-court', [BookingCourtController::class, 'store']);
});





/*
|--------------------------------------------------------------------------
| Admin API (AUTH + ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware(['setLocale', 'auth:sanctum'])->group(function () {

  Route::apiResource('users', UserController::class);

  Route::apiResource('categories', CategoryController::class)
    ->except(['index', 'show']);

  Route::apiResource('products', ProductController::class)
    ->except(['index', 'show']);

  Route::apiResource('product-variants', ProductVariantController::class)
    ->except(['index', 'show']);

  Route::apiResource('colors', ColorController::class)
    ->except(['index']);

  Route::apiResource('sizes', SizeController::class)
    ->except(['index']);

  Route::apiResource('courts', CourtController::class)
    ->except(['index', 'show']);
  Route::apiResource('couches', CouchController::class)
    ->except(['index', 'show']);

  Route::apiResource('training-programs', TrainingProgramController::class)
    ->except(['index', 'show']);

  Route::apiResource('all-subscriptions', TrainingSubscriptionController::class)
    ->except(['store']);

  Route::apiResource('sport-types', SportTypeController::class)
    ->except(['index', 'show']);
  Route::apiResource('times', TimeController::class)
    ->except(['index', 'show']);
});

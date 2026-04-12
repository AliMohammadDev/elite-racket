<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductVariantController;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CouchController;
use App\Http\Controllers\Api\CourtController;

/*
|--------------------------------------------------------------------------
| Public API (NO AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware(['setLocale'])->group(function () {

  // Auth
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);

  // Categories
  Route::get('categories', [CategoryController::class, 'index']);
  Route::get('categories/{category}', [CategoryController::class, 'show']);

  // Products
  Route::get('products', [ProductController::class, 'index']);
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

  Route::apiResource('courts', CourtController::class)->except(['index', 'show']);
  Route::apiResource('couches', CouchController::class)->except(['index', 'show']);


});

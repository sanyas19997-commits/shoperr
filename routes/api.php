<?php

use App\Http\Controllers\Api\ActionLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\InstagramPostController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\MenuItemController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'role:staff'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('change-password', [AuthController::class, 'changePassword']);

        Route::get('dashboard', [DashboardController::class, 'index']);

        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{product}', [ProductController::class, 'show']);
        Route::post('products', [ProductController::class, 'store']);
        Route::post('products/{product}', [ProductController::class, 'update']);
        Route::delete('products/{product}', [ProductController::class, 'destroy']);
        Route::delete('product-images/{image}', [ProductController::class, 'deleteImage']);

        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('categories/{category}', [CategoryController::class, 'show']);
        Route::post('categories', [CategoryController::class, 'store']);
        Route::post('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

        Route::get('brands/all', [BrandController::class, 'all']);
        Route::get('brands', [BrandController::class, 'index']);
        Route::get('brands/{brand}', [BrandController::class, 'show']);
        Route::post('brands', [BrandController::class, 'store']);
        Route::post('brands/{brand}', [BrandController::class, 'update']);
        Route::delete('brands/{brand}', [BrandController::class, 'destroy']);

        Route::get('orders/options', [OrderController::class, 'options']);
        Route::get('orders/export', [OrderController::class, 'exportCsv']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{order}', [OrderController::class, 'show']);
        Route::patch('orders/{order}', [OrderController::class, 'update']);
        Route::delete('orders/{order}', [OrderController::class, 'destroy']);

        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{user}', [UserController::class, 'show']);
        Route::post('users', [UserController::class, 'store']);
        Route::patch('users/{user}', [UserController::class, 'update']);
        Route::delete('users/{user}', [UserController::class, 'destroy']);

        Route::get('settings', [SettingController::class, 'index']);
        Route::post('settings', [SettingController::class, 'update']);

        Route::get('action-logs', [ActionLogController::class, 'index']);

        Route::post('media', [MediaController::class, 'upload']);
        Route::delete('media', [MediaController::class, 'destroy']);

        Route::get('posts', [PostController::class, 'index']);
        Route::get('posts/{post}', [PostController::class, 'show']);
        Route::post('posts', [PostController::class, 'store']);
        Route::post('posts/{post}', [PostController::class, 'update']);
        Route::delete('posts/{post}', [PostController::class, 'destroy']);

        Route::get('banners', [BannerController::class, 'index']);
        Route::get('banners/{banner}', [BannerController::class, 'show']);
        Route::post('banners', [BannerController::class, 'store']);
        Route::post('banners/{banner}', [BannerController::class, 'update']);
        Route::delete('banners/{banner}', [BannerController::class, 'destroy']);

        Route::get('testimonials', [TestimonialController::class, 'index']);
        Route::get('testimonials/{testimonial}', [TestimonialController::class, 'show']);
        Route::post('testimonials', [TestimonialController::class, 'store']);
        Route::post('testimonials/{testimonial}', [TestimonialController::class, 'update']);
        Route::delete('testimonials/{testimonial}', [TestimonialController::class, 'destroy']);

        Route::get('instagram', [InstagramPostController::class, 'index']);
        Route::get('instagram/{instagramPost}', [InstagramPostController::class, 'show']);
        Route::post('instagram', [InstagramPostController::class, 'store']);
        Route::post('instagram/{instagramPost}', [InstagramPostController::class, 'update']);
        Route::delete('instagram/{instagramPost}', [InstagramPostController::class, 'destroy']);

        Route::get('menu', [MenuItemController::class, 'index']);
        Route::get('menu/{menuItem}', [MenuItemController::class, 'show']);
        Route::post('menu', [MenuItemController::class, 'store']);
        Route::post('menu/{menuItem}', [MenuItemController::class, 'update']);
        Route::delete('menu/{menuItem}', [MenuItemController::class, 'destroy']);
    });
});

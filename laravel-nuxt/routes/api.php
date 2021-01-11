<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\ProductFeatureController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUser;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('user', [UserController::class, 'current']);
    Route::get('role', [UserController::class, 'getRole']);

    Route::patch('settings/profile', [ProfileController::class, 'update']);
    Route::patch('settings/password', [PasswordController::class, 'update']);
});

Route::group(
    [

        'middleware' => [
            // 'auth:api',
            // 'isAdmin'
        ],
        'prefix' => 'dashboard'
    ],
    function () {
        Route::get('/', [AdminUser::class, 'index']);
        Route::group(
            ['prefix' => 'product-category'],
            function () {
                Route::post('add', [ProductCategoryController::class, 'store']);
                Route::get('all', [ProductCategoryController::class, 'index']);
                Route::delete('/', [ProductCategoryController::class, 'destroy']);
                Route::post('/edit', [ProductCategoryController::class, 'update']);
            }
        );
        Route::group(
            ['prefix' => 'product-feature'],
            function () {
                Route::post('add', [ProductFeatureController::class, 'store']);
                Route::get('all', [ProductFeatureController::class, 'index']);
                Route::delete('/', [ProductFeatureController::class, 'destroy']);
                Route::post('edit', [ProductFeatureController::class, 'update']);
            }
        );
        Route::group(
            ['prefix' => 'product'],
            function () {
                Route::post('add', [ProductController::class, 'store']);
                Route::get('all', [ProductController::class, 'index']);
                Route::delete('/', [ProductController::class, 'destroy']);
                Route::post('edit', [ProductController::class, 'update']);
            }
        );
        Route::group(
            ['prefix' => 'user'],
            function () {
                Route::post('add', [AdminUser::class, 'store']);
                Route::get('all', [AdminUser::class, 'index']);
                Route::delete('/', [AdminUser::class, 'destroy']);
                Route::post('edit', [AdminUser::class, 'update']);
            }
        );
        Route::group(
            ['prefix' => 'roles'],
            function () {
                Route::post('add', [RoleController::class, 'store']);
                Route::get('all', [RoleController::class, 'index']);
                Route::delete('/', [RoleController::class, 'destroy']);
                Route::post('edit', [RoleController::class, 'update']);
            }
        );
    }
);

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('register', [RegisterController::class, 'register']);

    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);

    Route::post('email/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend']);

    Route::post('oauth/{driver}', [OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [OAuthController::class, 'handleCallback'])->name('oauth.callback');
});

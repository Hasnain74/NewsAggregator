<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\UserPreferenceController;
use App\Http\Controllers\Auth\ForgotPasswordController;
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
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::get('reset-password', [ResetPasswordController::class,'reset'])->name('password.reset');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/preference-articles', [ArticleController::class, 'preferenceBasedArticles']);
    Route::post('/logout', [LogoutController::class, 'logout']);
    Route::get('/filter-articles', [ArticleController::class, 'filterArticle']);
    Route::get('/preferences', [UserPreferenceController::class, 'getPreferences'])->name('preferences.get');
    Route::post('/preferences', [UserPreferenceController::class, 'setPreferences'])->name('preferences.set');
});

<?php

use App\Http\Controllers\Api\UserPortal\WalletTransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserPortal\AuthController;
use App\Http\Controllers\Api\UserPortal\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('two-step-verification', [AuthController::class, 'twoStepVerification']);
Route::post('resend-otp', [AuthController::class, 'resendOTP']);

Route::middleware('auth:users_api')->group(function () {
    Route::get('profile', [ProfileController::class, 'profile']);
    Route::post('change-password', [ProfileController::class, 'changePassword']);
    Route::post('logout', [AuthController::class, 'logout']);

    // Wallet Transaction 
    Route::get('wallet-transaction', [WalletTransactionController::class, 'index']);
    Route::get('wallet-transaction/{trx_id}', [WalletTransactionController::class, 'show']);
});
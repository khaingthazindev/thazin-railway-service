<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Select2AjaxController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\TicketInspectorController;

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

require __DIR__ . '/auth.php';

Route::middleware('auth:admin_users')->group(function () {
   Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
   Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

   Route::get('change-password', [PasswordController::class, 'edit'])->name('change-password.edit');
   Route::put('change-password', [PasswordController::class, 'update'])->name('change-password.update');
});

Route::middleware(['auth:admin_users', 'verified'])->group(function () {
   Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

   Route::resource('/admin-user', AdminUserController::class);
   Route::get('/admin-user-datatable', [AdminUserController::class, 'datatable'])->name('admin-user-datatable');

   Route::resource('/user', UserController::class);
   Route::get('/user-datatable', [UserController::class, 'datatable'])->name('user-datatable');

   Route::resource('/wallet', WalletController::class)->only(['index']);
   Route::get('/wallet-datatable', [WalletController::class, 'datatable'])->name('wallet-datatable');
   Route::get('/wallet-add-amount', [WalletController::class, 'addAmount'])->name('wallet-add-amount');
   Route::post('/wallet-add-amount', [WalletController::class, 'addAmountStore'])->name('wallet-add-amount.store');

   Route::resource('/ticket-inspector', TicketInspectorController::class);
   Route::get('/ticket-inspector-datatable', [TicketInspectorController::class, 'datatable'])->name('ticket-inspector-datatable');

   Route::prefix('select2-ajax')->name('select2-ajax.')->group(function () {
      Route::get('wallet', [Select2AjaxController::class, 'wallet'])->name('wallet');
   });
});
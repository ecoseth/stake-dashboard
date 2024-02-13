<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\SettingController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dash.index');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::post('/users/update-status', [UserController::class, 'updateStatus'])->name('update.status');

    Route::post('/users/get-tokens', [UserController::class, 'fetchToken'])->name('fetch.tokens');

    Route::get('/edit-profile/{id}', [UserController::class, 'editProfile'])->name('profile.edit');

    Route::put('edit-profile/{id}', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::get('/edit-password/{id}', [UserController::class, 'editPassword'])->name('password.edit');

    Route::put('/edit-password/{id}', [UserController::class, 'updatePassword'])->name('password.update');

    Route::resource('/rewards', LevelController::class);

    Route::get('user/{id}/transactions',[UserController::class, 'transaction'])->name('user.transactions');

    Route::get('/withdraws',[WithdrawController::class,'withdraws'])->name('withdraws');
    Route::post('/change-status',[WithdrawController::class,'approveStatus'])->name('users.withdraws.approveStatus');
    Route::post('/reject-status',[WithdrawController::class,'rejectStatus'])->name('users.withdraws.rejectStatus');
    Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
    Route::post('/settings/save',[SettingController::class ,'store'])->name('settings.save');

    Route::get('/users/{id}/manage-balance', [UserController::class, 'manageBalance'])->name('users.manage.balance');
    Route::post('/users/update-balance', [UserController::class, 'updateBalance'])->name('users.update.balance');
    Route::post('/users/update-profit', [UserController::class, 'updateProfit'])->name('users.update.profit');

});


Route::controller(LoginRegisterController::class)->group(function() {

    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');

});

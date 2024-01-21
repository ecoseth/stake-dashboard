<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginRegisterController;



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

Route::get('/',[DashboardController::class, 'index'])->name('dash.index');

Route::get('/users',[UserController::class, 'index'])->name('users.index');

Route::post('/users/update-status',[UserController::class,'updateStatus'])->name('update.status');

Route::post('/users/get-tokens',[UserController::class,'fetchToken'])->name('fetch.tokens');

Route::resource('/rewards', LevelController::class);

Route::get('/users/{id}/manage-balance', [UserController::class, 'manageBalance'])->name('manage.balance');

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});


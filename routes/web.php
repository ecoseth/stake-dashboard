<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


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

Route::get('/',[UserController::class, 'index']);

Route::post('/users/update-status',[UserController::class,'updateStatus'])->name('update.status');

Route::post('/users/get-tokens',[UserController::class,'fetchToken'])->name('fetch.tokens');

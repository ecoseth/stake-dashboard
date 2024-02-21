<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\LevelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;
use App\Http\Controllers\HomeController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/user-info',[UserController::class,'getUserInfo']);

Route::get('/user/{wallet}', [UserController::class, 'show']);

Route::get('/level',[LevelController::class,'levelData']);

Route::post('/create/withdraw',[WithdrawController::class,'createWithdraw']);

Route::get('/home-assets',[HomeController::class,'homeAsset']);

Route::get('/get-blocks',[HomeController::class,'getBlock']);

Route::get('/get-wallet-data/{id}',[HomeController::class,'getUserStats']);

Route::post('/swap-usdt/{id}',[HomeController::class,'getSwap']);
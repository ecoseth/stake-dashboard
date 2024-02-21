<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\LevelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawController;


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

Route::post('/user-info',[ApiController::class,'getUserInfo']);

Route::get('/user/{wallet}', [ApiController::class, 'getWallet']);

Route::get('/level',[ApiController::class,'levelData']);

Route::post('/create/withdraw',[ApiController::class,'createWithdraw']);

Route::get('/home-assets',[ApiController::class,'homeAsset']);

Route::get('/get-blocks',[ApiController::class,'getBlock']);

Route::get('/get-wallet-data/{id}',[ApiController::class,'getUserStats']);

Route::post('/swap-usdt/{id}',[ApiController::class,'getSwap']);
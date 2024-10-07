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

    Route::post('/wallet-info',[ApiController::class,'setWalletConnect']);

    Route::post('/user-info',[ApiController::class,'getUserInfo']);

    Route::get('/user/{wallet}', [ApiController::class, 'getWallet']);
    
    Route::get('/level',[ApiController::class,'levelData']);
    
    Route::post('/create/withdraw',[ApiController::class,'createWithdraw']);

    Route::post('/wallet/updateBlanace/{user_id}/{balance}/{type}',[ApiController::class,'updateBalance']);
    
    Route::get('/home-assets',[ApiController::class,'homeAsset']);

    Route::get('/contents',[ApiController::class,'getContent']);
    
    Route::get('/get-blocks',[ApiController::class,'getBlock']);
    
    Route::get('/get-wallet-data/{id}',[ApiController::class,'getUserStats']);
    
    Route::post('/swap-usdt/{id}',[ApiController::class,'getSwap']);

    Route::get('/update-usdt-exchange',[ApiController::class,'ethUsdtExchange']);

    Route::get('/chat-config',[ApiController::class,'chatConfig']);

    Route::get('/partners',[ApiController::class,'getPartnerList']);
    
// });


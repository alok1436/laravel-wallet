<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Authenticaed routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/addMoney', [WalletController::class, 'addMoney']);
    Route::post('/buyACookie', [UserController::class, 'buyACookie']);
});

//unauthenticaed routes
Route::post('/login', [AuthController::class, 'loginUser']);
Route::post('/register', [AuthController::class, 'createUser']);
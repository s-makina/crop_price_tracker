<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CropController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\MarketController;
use App\Http\Controllers\Api\CropPricesController;
use App\Http\Controllers\Api\MarketCropsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('crops', CropController::class);

        // Crop Prices
        Route::get('/crops/{crop}/prices', [
            CropPricesController::class,
            'index',
        ])->name('crops.prices.index');
        Route::post('/crops/{crop}/prices', [
            CropPricesController::class,
            'store',
        ])->name('crops.prices.store');

        Route::apiResource('markets', MarketController::class);

        // Market Crops
        Route::get('/markets/{market}/crops', [
            MarketCropsController::class,
            'index',
        ])->name('markets.crops.index');
        Route::post('/markets/{market}/crops', [
            MarketCropsController::class,
            'store',
        ])->name('markets.crops.store');

        Route::apiResource('prices', PriceController::class);

        Route::apiResource('users', UserController::class);
    });

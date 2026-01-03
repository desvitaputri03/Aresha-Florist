<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentGatewayController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Rute untuk Payment Gateway Webhook
Route::post('/payment-gateway/webhook', [PaymentGatewayController::class, 'handleWebhook'])->name('payment-gateway.webhook');

// Geo Data API Routes
Route::get('/provinces', [App\Http\Controllers\GeoController::class, 'getProvinces']);
Route::get('/regencies/{provinceId}', [App\Http\Controllers\GeoController::class, 'getRegencies']);
Route::get('/districts/{regencyId}', [App\Http\Controllers\GeoController::class, 'getDistricts']);
Route::get('/postal-code/{districtId}', [App\Http\Controllers\GeoController::class, 'getPostalCode']);


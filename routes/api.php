<?php

use App\Http\Controllers\API\v1\ReceiptController as V1ReceiptController;
use Illuminate\Support\Facades\Route;

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

Route::name('v1.')->prefix('v1')->group(static function () {
    Route::apiResource('receipts', V1ReceiptController::class);
});

<?php

use App\Http\Controllers\Api\ActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiBlockIpMiddleware;

/**
 * Routes Api
 */

Route::post('v1/token', [ActivityController::class, 'token']);

Route::group(['prefix'=>'v1', 'middleware'=>['auth:sanctum', 'throttle:apiRateLimiting', ApiBlockIpMiddleware::class]], function (){
    Route::get('activities', [ActivityController::class, 'index']);
    Route::get('activities/types/{activity_type}', [ActivityController::class, 'filterByActivityType']);
    Route::post('activities', [ActivityController::class, 'store']);
});

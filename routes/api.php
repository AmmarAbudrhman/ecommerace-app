<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandsController;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

});

Route::controller(BrandsController::class)->group(function () {
    Route::get('/brands', 'index');
    Route::get('/brands/{id}', 'show');
    Route::post('/brands', 'store');
    Route::put('/brands/{id}', 'update_brand');
    Route::delete('/brands/{id}', 'destroy');
});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
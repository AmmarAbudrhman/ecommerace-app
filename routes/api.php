<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Brands;
use App\Http\Controllers\Catgories;
use App\Http\Controllers\Locations;
use App\Http\Controllers\Products;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

});

Route::prefix('brands')->group(function () {
    Route::get('/', Brands\IndexController::class);
    Route::get('/{id}', Brands\ShowController::class);
    Route::post('/', Brands\StoreController::class);
    Route::put('/{id}', Brands\UpdateController::class);
    Route::delete('/{id}', Brands\DestroyController::class);
});

Route::prefix('catgories')->group(function () {
    Route::get('/', Catgories\IndexController::class);
    Route::get('/{id}', Catgories\ShowController::class);
    Route::post('/', Catgories\StoreController::class);
    Route::put('/{id}', Catgories\UpdateController::class);
    Route::delete('/{id}', Catgories\DestroyController::class);
});

Route::prefix('locations')->group(function () {
    Route::get('/', Locations\IndexController::class);
    Route::post('/', Locations\StoreController::class);
    Route::put('/{id}', Locations\UpdateController::class);
    Route::delete('/{id}', Locations\DestroyController::class);
});

Route::prefix('products')->group(function () {
    Route::get('/', Products\IndexController::class);
    Route::get('/{id}', Products\ShowController::class);
    Route::post('/', Products\StoreController::class);
    Route::put('/{id}', Products\UpdateController::class);
    Route::delete('/{id}', Products\DestroyController::class);
});



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
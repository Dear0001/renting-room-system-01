<?php

use App\Http\Controllers\API\RoomAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::group(['prefix' => 'api'], function () {
    Route::get('rooms', [RoomAPIController::class, 'index']);
    Route::get('rooms/{id}', [RoomAPIController::class, 'show']);
    Route::post('rooms', [RoomAPIController::class, 'store']);
    Route::put('rooms/{id}', [RoomAPIController::class, 'update']);
    Route::delete('rooms/{id}', [RoomAPIController::class, 'destroy']);
});

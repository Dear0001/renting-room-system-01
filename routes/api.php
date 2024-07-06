<?php

use App\Http\Controllers\API\FloorAPIController;

use App\Http\Controllers\API\RoomAPIController;
use App\Http\Controllers\API\RoomCategoryAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

    Route::get('/rooms', [RoomAPIController::class, 'index']);
    Route::get('/rooms/{id}', [RoomAPIController::class, 'show']);
    Route::post('/rooms', [RoomAPIController::class, 'store']);
    Route::put('/rooms/{id}', [RoomAPIController::class, 'update']);
    Route::delete('rooms/{id}', [RoomAPIController::class, 'destroy']);
    Route::put('/rooms/{id}/book', [RoomAPIController::class, 'bookRoom']);
    Route::put('/rooms/{id}/free', [RoomAPIController::class, 'freeRoom']);
    Route::get('/rooms/available', [RoomAPIController::class, 'getAvailableRooms']);
    Route::get('/rooms/unavailable', [RoomAPIController::class, 'getUnavailableRooms']);
    Route::get('/rooms/category/{name}', [RoomAPIController::class, 'getAllRoomByCategoryName']);

    //Room Categories
    Route::get('/categories', [RoomCategoryAPIController::class, 'index']);
    Route::post('/categories', [RoomCategoryAPIController::class, 'store']);
    Route::get('/categories/{id}', [RoomCategoryAPIController::class, 'show']);
    Route::put('/categories/{id}', [RoomCategoryAPIController::class, 'update']);
    Route::delete('/categories/{id}', [RoomCategoryAPIController::class, 'destroy']);
    //Floors
    Route::get('/floors', [FloorAPIController::class, 'index']);
    Route::post('/floors', [FloorAPIController::class, 'store']);
    Route::get('/floors/{id}', [FloorAPIController::class, 'show']);
    Route::put('/floors/{id}', [FloorAPIController::class, 'update']);
    Route::delete('/floors/{id}', [FloorAPIController::class, 'destroy']);

  
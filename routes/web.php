<?php

use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\RoomCategoryController;
use App\Http\Controllers\Admin\RoomController;
use Illuminate\Support\Facades\Route;

// List rooms
// routes/web.php
Route::get('admin/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/admin/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/admin/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/admin/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/admin/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
Route::put('/admin/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/admin/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

//Route::prefix('admin')->group(function () {
    Route::get('/admin/floors', [FloorController::class, 'index'])->name('floors.index');
    Route::get('/admin/floors/create', [FloorController::class, 'create'])->name('floors.create');
    Route::post('/admin/floors', [FloorController::class, 'store'])->name('floors.store');
    Route::get('/admin/floors/{id}', [FloorController::class, 'show'])->name('floors.show');
    Route::get('/admin/floors/{id}/edit', [FloorController::class, 'edit'])->name('floors.edit');
    Route::put('/admin/floors/{id}', [FloorController::class, 'update'])->name('floors.update');
    Route::delete('/admin/floors/{id}', [FloorController::class, 'destroy'])->name('floors.destroy');
//});

//Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/admin/categories', [RoomCategoryController::class, 'index'])->name('categories.index');
    Route::post('/admin/categories', [RoomCategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/create', [RoomCategoryController::class, 'create'])->name('categories.create');
    Route::get('/admin/categories/{id}', [RoomCategoryController::class, 'show'])->name('categories.show');
    Route::put('/admin/categories/{id}', [RoomCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{id}', [RoomCategoryController::class, 'destroy'])->name('categories.destroy');

//});

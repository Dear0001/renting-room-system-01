<?php

use App\Http\Controllers\Admin\RoomController;
use Illuminate\Support\Facades\Route;

// List rooms
Route::get('/', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/admin/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
Route::post('/admin/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::get('/admin/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');
Route::get('/admin/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
Route::put('/admin/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/admin/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

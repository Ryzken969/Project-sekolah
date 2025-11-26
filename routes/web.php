<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\TaskController;

// ========================
// HALAMAN AWAL
// ========================
Route::get('/', function () {
    return redirect()->route('todolist.index');
    // Kalau mau pakai welcome lagi, ganti dengan:
    // return view('welcome');
});

// ========================
// ROUTE CRUD ITEM
// ========================
Route::resource('items', ItemController::class);

// ========================
// ROUTE CRUD TODOLIST
// ========================
Route::resource('todolist', TodolistController::class);

// ========================
// ROUTE CRUD TASK
// ========================
Route::resource('tasks', TaskController::class);

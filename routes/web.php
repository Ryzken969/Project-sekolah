<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TodolistController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Route CRUD untuk Item
Route::resource('items', ItemController::class);

// Route CRUD untuk Todolist
Route::resource('todolist', TodolistController::class);

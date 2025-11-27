<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\TaskController;

// Redirect otomatis dari "/" ke "/todolist"
Route::get('/', function () {
    return redirect()->route('todolist.index');
});

// Route CRUD Todolist
Route::resource('todolist', TodolistController::class);

// Route Task (hanya tambah & hapus)
Route::resource('tasks', TaskController::class)->only(['store', 'destroy']);

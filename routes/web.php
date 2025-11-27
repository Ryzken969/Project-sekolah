<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\TaskController;

// Redirect otomatis dari "/" ke "/todolist"
Route::get('/', function () {
    return redirect()->route('todolist.index');
});

// ============================
// TODOLIST ROUTES
// ============================
Route::resource('todolist', TodolistController::class);

// ============================
// TASK ROUTES (Hanya Tambah & Hapus)
// ============================
Route::post('/task', [TaskController::class, 'store'])->name('task.store');
Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');

// (Opsional jika kamu punya halaman semua task)
Route::get('/task', [TaskController::class, 'index'])->name('task.index');

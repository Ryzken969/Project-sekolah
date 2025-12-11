<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodolistController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Redirect utama
|--------------------------------------------------------------------------
| Ketika user membuka "/", otomatis pindah ke halaman todolist.index
*/
Route::get('/', function () {
    return redirect()->route('todolist.index');
});


/*
|--------------------------------------------------------------------------
| TODOLIST ROUTES (CRUD)
|--------------------------------------------------------------------------
*/
Route::resource('todolist', TodolistController::class);


/*
|--------------------------------------------------------------------------
| TASK ROUTES
|--------------------------------------------------------------------------
| Task hanya butuh:
| - store → tambah task
| - destroy → hapus task
| - (opsional) index → jika ingin lihat semua task
*/
Route::post('/task', [TaskController::class, 'store'])->name('task.store');
Route::delete('/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy');

// Opsional — jika kamu punya halaman list semua task
Route::get('/task', [TaskController::class, 'index'])->name('task.index');

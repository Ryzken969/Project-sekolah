<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/refresh-csrf', function () {
    return response()->json(['token' => csrf_token()]);
});

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [TodoController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::prefix('todos')->middleware('auth')->group(function () {
    Route::get('/', [TodoController::class, 'index'])->name('todos.index');
    Route::post('/', [TodoController::class, 'store'])->name('todos.store');
    Route::put('/{id}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('/{id}', [TodoController::class, 'destroy'])->name('todos.destroy');
    Route::post('/{id}/status', [TodoController::class, 'updateStatus'])->name('todos.updateStatus');
});
Route::post('/todos/submit-selected', [TodoController::class, 'submitSelected'])->name('todos.submitSelected')->middleware('auth');
Route::post('/lists', [TodoController::class, 'store'])->name('lists.store');
Route::delete('/lists/{list}', [TodoController::class, 'destroy'])->name('lists.destroy');
Route::get('/report', [ReportController::class, 'index'])->middleware(['auth'])->name('report');
Route::get('/report/export/csv', [ReportController::class, 'exportCSV'])->name('report.export.csv');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

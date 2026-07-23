<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/trashed', [StudentController::class, 'trashed']);
    Route::get('/students/{student}/edit', [StudentController::class, 'edit']);
    Route::put('/students/{student}', [StudentController::class, 'update']);
    Route::delete('/students/{student}', [StudentController::class, 'destroy']);
    Route::patch('/students/{id}/restore', [StudentController::class, 'restore']);
});

require __DIR__.'/settings.php';
<?php

use Illuminate\Support\Facades\Route;
use Modules\Student\Http\Controllers\StudentController;

/*
|--------------------------------------------------------------------------
| Web Routes - Student Domain
|--------------------------------------------------------------------------
| Handles HTTP routing for student management operations.
| Static routes (like /trashed) are defined before wildcard parameter 
| bindings ({student}) to prevent route matching collisions.
*/

Route::middleware(['auth', 'verified'])->prefix('students')->name('students.')->group(function () {
    // Standard Listing & Creation
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::post('/', [StudentController::class, 'store'])->name('store');

    // Soft-Deleted / Archived Management Routes
    Route::get('/trashed', [StudentController::class, 'trashed'])->name('trashed');
    Route::patch('/{id}/restore', [StudentController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [StudentController::class, 'forceDelete'])->name('force-delete');

    // Individual Resource Operations
    Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
    Route::put('/{student}', [StudentController::class, 'update'])->name('update');
    Route::delete('/{student}', [StudentController::class, 'destroy'])->name('destroy');
});
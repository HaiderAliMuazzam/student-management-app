<?php

use Illuminate\Support\Facades\Route;
use Modules\Grade\Http\Controllers\GradeController;

// Grade routes require a logged-in, verified user
Route::middleware(['auth', 'verified'])->group(function () {
    // List all grades (with the create form on the same page)
    Route::get('/grades', [GradeController::class, 'index']);

    // Create a new grade
    Route::post('/grades', [GradeController::class, 'store']);

    // Show edit form for a single grade — {grade} must match GradeRequest's route('grade') lookup
    Route::get('/grades/{grade}/edit', [GradeController::class, 'edit']);

    // Update — PUT is the REST convention for full-resource update
    Route::put('/grades/{grade}', [GradeController::class, 'update']);

    // Delete
    Route::delete('/grades/{grade}', [GradeController::class, 'destroy']);
});
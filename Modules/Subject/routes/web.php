<?php

use Illuminate\Support\Facades\Route;
use Modules\Subject\Http\Controllers\SubjectController;

// Subject routes require a logged-in, verified user
Route::middleware(['auth', 'verified'])->group(function () {
    // List all subjects (with the create form on the same page)
    Route::get('/subjects', [SubjectController::class, 'index']);

    // Create a new subject
    Route::post('/subjects', [SubjectController::class, 'store']);

    // Show edit form for a single subject — {subject} must match SubjectRequest's route('subject') lookup
    Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit']);

    // Update — PUT is the REST convention for full-resource update
    Route::put('/subjects/{subject}', [SubjectController::class, 'update']);

    // Delete
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy']);
});
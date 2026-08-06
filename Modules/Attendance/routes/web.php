<?php

use Illuminate\Support\Facades\Route;
use Modules\Attendance\Http\Controllers\AttendanceController;

Route::middleware(['auth', 'verified'])->group(function () {

    // Attendance routes (core-only).
    Route::get('/attendances', [AttendanceController::class, 'index'])
        ->name('attendance.index');

    Route::post('/attendances', [AttendanceController::class, 'store'])
        ->name('attendance.store');

});
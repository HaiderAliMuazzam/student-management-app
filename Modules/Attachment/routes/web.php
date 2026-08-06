<?php

use Illuminate\Support\Facades\Route;
use Modules\Attachment\Http\Controllers\AttachmentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('attachments', [AttachmentController::class, 'store'])->name('attachments.store');
    Route::delete('attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
});
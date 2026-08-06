<?php

use Illuminate\Support\Facades\Route;
use Modules\Attachment\Http\Controllers\AttachmentController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('attachments', AttachmentController::class)->names('attachment');
});

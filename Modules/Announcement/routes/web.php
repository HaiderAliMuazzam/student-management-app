<?php

use Illuminate\Support\Facades\Route;
use Modules\Announcement\Http\Controllers\AnnouncementController;

/*
|--------------------------------------------------------------------------
| Announcement Routes
|--------------------------------------------------------------------------
|
| Why don't we use Route::resource()?
| -----------------------------------
| Route::resource() automatically creates seven RESTful routes
| (index, create, store, show, edit, update, destroy).
|
| We now need edit/update/destroy too (previously core-only), so those
| are added explicitly below — still skipping create/show since this
| module uses an inline create form on the index page, not a separate
| create page or detail page.
|
*/

Route::middleware(['auth', 'verified'])->group(function () {

    /**
     * Display all announcements.
     *
     * GET /announcements
     */
    Route::get('/announcements', [AnnouncementController::class, 'index'])
        ->name('announcements.index');

    /**
     * Store a new announcement.
     *
     * POST /announcements
     */
    Route::post('/announcements', [AnnouncementController::class, 'store'])
        ->name('announcements.store');

    /**
     * Show edit form for a single announcement.
     *
     * GET /announcements/{announcement}/edit
     */
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])
        ->name('announcements.edit');

    /**
     * Update an existing announcement.
     *
     * PUT /announcements/{announcement}
     */
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])
        ->name('announcements.update');

    /**
     * Delete an announcement.
     *
     * DELETE /announcements/{announcement}
     */
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])
        ->name('announcements.destroy');
});
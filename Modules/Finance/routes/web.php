<?php

use Illuminate\Support\Facades\Route;
use Modules\Finance\Http\Controllers\InvoiceController;
use Modules\Finance\Http\Controllers\PaymentController;

// All invoice/payment routes require a logged-in, verified user
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Invoice routes ---

    // List all invoices (with optional filters)
    Route::get('/invoices', [InvoiceController::class, 'index']);

    // Create a new invoice
    Route::post('/invoices', [InvoiceController::class, 'store']);

    // Show soft-deleted invoices, same pattern as Student's trashed view.
    // NOTE: must be registered BEFORE '/invoices/{invoice}/edit',
    // otherwise Laravel would try to match "trashed" as an {invoice} id/slug.
    Route::get('/invoices/trashed', [InvoiceController::class, 'trashed']);

    // Show the edit form for one invoice
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit']);

    // Update an existing invoice's static fields (title, amount, due_date, student_id).
    // status/amount_paid are not editable here — those are driven by Payment.
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update']);

    // Soft-delete an invoice (uses SoftDeletes on the model, so this doesn't
    // permanently remove the row — it sets deleted_at).
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy']);

    // Restore a soft-deleted invoice by id.
    Route::patch('/invoices/{id}/restore', [InvoiceController::class, 'restore']);

    // --- Payment routes ---

    // List all payments (with optional invoice filter)
    Route::get('/payments', [PaymentController::class, 'index']);

    // Record a new payment against an invoice.
    // No update/delete routes — payments are immutable once created.
    Route::post('/payments', [PaymentController::class, 'store']);
});
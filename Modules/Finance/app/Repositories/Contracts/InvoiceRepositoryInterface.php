<?php

namespace Modules\Finance\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Finance\Models\Invoice;

interface InvoiceRepositoryInterface
{
    // Get all invoices, optionally filtered (e.g. by student, status)
    public function all(array $filters = []);

    // Create a new invoice
    public function create(array $data): Invoice;

    // Update an existing invoice
    public function update(Invoice $invoice, array $data): Invoice;

    // Soft-delete an invoice
    public function delete(Invoice $invoice): void;

    // Get all soft-deleted (trashed) invoices, paginated
    public function trashed(): LengthAwarePaginator;

    // Restore a soft-deleted invoice by id
    public function restore(int $id): void;
}
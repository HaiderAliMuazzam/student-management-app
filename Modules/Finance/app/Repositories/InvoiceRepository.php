<?php

namespace Modules\Finance\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Finance\Models\Invoice;
use Modules\Finance\Repositories\Contracts\InvoiceRepositoryInterface;

// This is the "how" — the actual implementation of the interface's promises.
class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = Invoice::query();

        // Only filter by student if one was actually passed in
        if (!empty($filters['student_id'])) {
            $query->where('student_id', $filters['student_id']);
        }

        // Only filter by status if one was actually passed in
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Newest invoices first, 10 per page (same pagination style as StudentRepository)
        return $query->with('student')->latest()->paginate(10);
    }

    public function create(array $data): Invoice
    {
        // $data comes from validated form input in the controller
        return Invoice::create($data);
    }

    public function update(Invoice $invoice, array $data): Invoice
    {
        $invoice->update($data);

        return $invoice;
    }

    public function delete(Invoice $invoice): void
    {
        // Soft delete — since the model uses SoftDeletes, this doesn't
        // actually remove the row, just sets deleted_at
        $invoice->delete();
    }

    public function trashed(): LengthAwarePaginator
    {
        // Only fetch invoices that have been soft-deleted (deleted_at is not null)
       return Invoice::onlyTrashed()->with('student')->paginate(10);
    }

    public function restore(int $id): void
    {
        // Find the trashed invoice by id and restore it (clears deleted_at)
        Invoice::onlyTrashed()->findOrFail($id)->restore();
    }
}
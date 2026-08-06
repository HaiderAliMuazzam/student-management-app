<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Finance\Models\Invoice;
use Modules\Finance\Repositories\Contracts\InvoiceRepositoryInterface;
use Modules\Student\Models\Student;

class InvoiceController extends Controller
{
    // Same pattern as StudentController: depend on the interface, not the concrete class.
    // This keeps the controller decoupled from the actual database/query logic.
    protected InvoiceRepositoryInterface $invoices;

    public function __construct(InvoiceRepositoryInterface $invoices)
    {
        $this->invoices = $invoices;
    }

    // List invoices, with optional filters (student, status)
    public function index(Request $request)
    {
        // Pull only the filter keys we care about from the query string.
        // e.g. /invoices?student_id=3&status=paid
        $filters = $request->only(['student_id', 'status']);

        // Repository handles the actual filtering + pagination logic.
        $invoices = $this->invoices->all($filters);

        // Needed for the "filter by student" dropdown and the "create invoice" form.
        // Cross-module read (Finance -> Student), since there's no dedicated
        // Student repository call exposed to this module yet.
        $students = Student::all();

        return view('finance::invoices.index', [
            'invoices' => $invoices,
            'filters' => $filters,
            'students' => $students,
        ]);
    }

    // Create a new invoice
    public function store(Request $request)
    {
        // Validate incoming form data before creating the invoice.
        // student_id must reference an existing row in the students table.
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $this->invoices->create($validated);

        // Redirect back to the index so the new invoice shows up in the table.
        return redirect('/invoices');
    }

    // Edit form for one invoice
    public function edit(Invoice $invoice)
    {
        // Route-model binding automatically resolves {invoice} in the route
        // to an Invoice instance, same pattern as StudentController::edit(Student $student).

        // TODO: add a Gate::denies('manage-invoices') check here once that
        // permission is defined, matching StudentController's authorization pattern.

        // Needed for the "reassign student" dropdown in the edit form.
        $students = Student::all();

        return view('finance::invoices.edit', [
            'invoice' => $invoice,
            'students' => $students,
        ]);
    }

    // Update an existing invoice's static fields.
    // Note: status and amount_paid are intentionally NOT editable here —
    // those will be driven by the Payment workflow later (e.g. a payment
    // being recorded will update amount_paid and recalculate status).
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
        ]);

        $this->invoices->update($invoice, $validated);

        return redirect('/invoices');
    }

    // Soft-delete an invoice
    public function destroy(Invoice $invoice)
    {
        // TODO: add a Gate::denies('delete-invoice') check here once that
        // permission is defined, matching StudentController::destroy().

        $this->invoices->delete($invoice);

        return redirect('/invoices');
    }

    // Show soft-deleted invoices
    public function trashed()
    {
        // TODO: add a Gate::denies('manage-invoices') check here once that
        // permission is defined, matching StudentController::trashed().

        $invoices = $this->invoices->trashed();

        return view('finance::invoices.trashed', ['invoices' => $invoices]);
    }

    // Restore a soft-deleted invoice by id
    public function restore($id)
    {
        // TODO: add a Gate::denies('manage-invoices') check here once that
        // permission is defined, matching StudentController::restore().

        $this->invoices->restore($id);

        return redirect('/invoices/trashed');
    }
}
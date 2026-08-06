<?php

namespace Modules\Finance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Finance\Models\Invoice;
use Modules\Finance\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentController extends Controller
{
    protected PaymentRepositoryInterface $payments;

    public function __construct(PaymentRepositoryInterface $payments)
    {
        $this->payments = $payments;
    }

    // List payments, optionally filtered by invoice
    public function index(Request $request)
    {
        $filters = $request->only(['invoice_id']);
        $payments = $this->payments->all($filters);

        // Needed for the "filter by invoice" dropdown and the "record payment" form
        $invoices = Invoice::all();

        return view('finance::payments.index', [
            'payments' => $payments,
            'filters' => $filters,
            'invoices' => $invoices,
        ]);
    }

    // Record a new payment against an invoice.
    // No update()/destroy() — payments are immutable once created,
    // matching how a real payment ledger behaves.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'amount' => 'required|numeric|min:0.01',
            'paid_at' => 'required|date',
        ]);

        // Repository handles creation AND dispatches PaymentReceived,
        // which triggers the listener to update the Invoice's
        // amount_paid and status automatically.
        $this->payments->create($validated);

        return redirect('/payments');
    }
}
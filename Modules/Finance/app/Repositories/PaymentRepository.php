<?php

namespace Modules\Finance\Repositories;

use Modules\Finance\Events\PaymentReceived;
use Modules\Finance\Models\Payment;
use Modules\Finance\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = Payment::query();

        // Only filter by invoice if one was actually passed in
        if (!empty($filters['invoice_id'])) {
            $query->where('invoice_id', $filters['invoice_id']);
        }

        // Newest payments first, 10 per page (same pagination style as InvoiceRepository)
        return $query->with('invoice.student')->latest()->paginate(10);
    }

    public function create(array $data): Payment
    {
        // $data comes from validated form input in the controller
        $payment = Payment::create($data);

        // Dispatch the event so the listener can update the related
        // Invoice's amount_paid and status. This is what actually
        // connects Payment to Invoice — the repository doesn't touch
        // Invoice directly, the event/listener does.
        PaymentReceived::dispatch($payment);

        return $payment;
    }
}
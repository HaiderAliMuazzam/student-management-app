<?php

namespace Modules\Finance\Listeners;

use Modules\Finance\Enums\InvoiceStatus;
use Modules\Finance\Events\PaymentReceived;

class UpdateInvoiceOnPaymentReceived
{
    /**
     * Handle the event.
     *
     * When a payment is recorded, add its amount to the invoice's
     * amount_paid, then recalculate the invoice's status based on
     * how much has been paid relative to the total amount owed.
     */
    public function handle(PaymentReceived $event): void
    {
        $payment = $event->payment;
        $invoice = $payment->invoice;

        // Add this payment's amount to the running total already paid.
        $newAmountPaid = $invoice->amount_paid + $payment->amount;

        // Work out the new status based on how much has been paid so far:
        // - nothing paid yet -> Pending
        // - some paid, but less than the full amount -> Partial
        // - paid in full (or somehow overpaid) -> Paid
        $newStatus = match (true) {
            $newAmountPaid <= 0 => InvoiceStatus::Pending,
            $newAmountPaid < $invoice->amount => InvoiceStatus::Partial,
            default => InvoiceStatus::Paid,
        };

        $invoice->update([
            'amount_paid' => $newAmountPaid,
            'status' => $newStatus,
        ]);
    }
}
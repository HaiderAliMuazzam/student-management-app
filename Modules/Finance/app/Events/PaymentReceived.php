<?php

namespace Modules\Finance\Events;

use Modules\Finance\Models\Payment;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentReceived
{
    use Dispatchable, SerializesModels;

    // Carries the Payment that was just created. The listener will use
    // $this->payment->invoice to know which Invoice to update.
    public function __construct(
        public Payment $payment
    ) {}
}
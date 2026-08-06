<?php

namespace Modules\Finance\Repositories\Contracts;

use Modules\Finance\Models\Payment;

interface PaymentRepositoryInterface
{
    // Get all payments, optionally filtered (e.g. by invoice)
    public function all(array $filters = []);

    // Create a new payment
    public function create(array $data): Payment;
}
<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Payment extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    // Explicitly tells Laravel where to find this model's factory,
    // same pattern as Invoice::newFactory() and Student::newFactory().
    protected static function newFactory()
    {
        return \Modules\Finance\Database\Factories\PaymentFactory::new();
    }

    protected $fillable = [
        'invoice_id',
        'amount',
        'paid_at',
    ];

    // amount: keeps decimal precision instead of float rounding issues.
    // paid_at: gives you a Carbon date object instead of a raw string.
    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'date',
    ];

    // No SoftDeletes trait here — payments are immutable once created.
    // Audit log still tracks creation (useful for compliance/history),
    // even though updates/deletes shouldn't normally happen.
    protected $auditInclude = [
        'invoice_id',
        'amount',
        'paid_at',
    ];

    /**
     * The invoice this payment applies to.
     * Lets you call $payment->invoice->title instead of a manual query.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
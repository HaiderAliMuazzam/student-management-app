<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Finance\Enums\InvoiceStatus;
use Modules\Student\Models\Student; // cross-module relationship: Finance depends on Student
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Invoice extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    // Explicitly tells Laravel where to find this model's factory.
    // Needed because module-namespaced models (Modules\Finance\Models\Invoice)
    // don't match Laravel's default factory auto-discovery path.
    // Same pattern as Student::newFactory().
    protected static function newFactory()
    {
        return \Modules\Finance\Database\Factories\InvoiceFactory::new();
    }

    protected $fillable = [
        'student_id',
        'title',
        'amount',
        'amount_paid',
        'status',
        'due_date',
    ];

    // Casts turn plain DB values into richer PHP types automatically.
    // status: DB stores a string ("pending"), but PHP gives you InvoiceStatus::Pending — type-safe, autocompletes.
    // amount/amount_paid: keeps decimal precision instead of float rounding issues.
    // due_date: gives you a Carbon date object instead of a raw string.

    protected $casts = [
        'status' => InvoiceStatus::class,
        'amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'due_date' => 'date',
    ];

    // Same audit pattern as Student — logs only these fields, only when they actually change.
    protected $auditInclude = [
        'title',
        'amount',
        'amount_paid',
        'status',
        'due_date',
    ];

    /**
     * The student this invoice belongs to.
     * Lets you call $invoice->student->name instead of a manual query.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
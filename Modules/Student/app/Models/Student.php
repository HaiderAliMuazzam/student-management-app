<?php

namespace Modules\Student\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Grade\Models\Grade;
use Modules\Subject\Models\Subject;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'grade_id',
        'subject_id',
        'contact_number',
    ];

    /**
     * Relationship to Grade model for UI display ($student->grade->name)
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Relationship to Subject model for UI display ($student->subject->name)
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
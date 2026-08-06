<?php

namespace Modules\Attendance\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Student\Models\Student;

/**
 * Attendance Model
 *
 * Represents a student's attendance record.
 */
class Attendance extends Model
{
    /**
     * Fields that can be mass assigned.
     */
    protected $fillable = [
        'student_id',
        'attendance_date',
        'status',
    ];

    /**
     * An attendance record belongs to one student.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
<?php

namespace Modules\Attendance\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Attendance\Models\Attendance;
use Modules\Attendance\Repositories\Contracts\AttendanceRepositoryInterface;

/**
 * Handles attendance database operations.
 */
class AttendanceRepository implements AttendanceRepositoryInterface
{
    /**
     * Retrieve all attendance records with the related student.
     */
    public function all(): Collection
    {
        return Attendance::with('student')
            ->latest()
            ->get();
    }

    /**
     * Store a new attendance record.
     */
    public function create(array $data): Attendance
    {
        return Attendance::create($data);
    }
}
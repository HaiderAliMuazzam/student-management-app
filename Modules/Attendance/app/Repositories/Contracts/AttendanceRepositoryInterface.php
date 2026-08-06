<?php

namespace Modules\Attendance\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\Attendance\Models\Attendance;

/**
 * Repository contract for attendance operations.
 */
interface AttendanceRepositoryInterface
{
    /**
     * Retrieve all attendance records.
     */
    public function all(): Collection;

    /**
     * Store a new attendance record.
     */
    public function create(array $data): Attendance;
}
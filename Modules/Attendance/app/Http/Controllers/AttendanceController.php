<?php

namespace Modules\Attendance\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Attendance\Repositories\Contracts\AttendanceRepositoryInterface;
use Modules\Student\Models\Student;

class AttendanceController extends Controller
{
    /**
     * Repository instance.
     */
    public function __construct(
        private AttendanceRepositoryInterface $attendanceRepository
    ) {}

    /**
     * Display attendance records.
     */
    public function index()
    {
        return view('attendance::index', [
            'attendances' => $this->attendanceRepository->all(),
            'students' => Student::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a new attendance record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'attendance_date' => ['required', 'date'],
            'status' => ['required', 'in:Present,Absent,Late'],
        ]);

        $this->attendanceRepository->create($validated);

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance recorded successfully.');
    }
}
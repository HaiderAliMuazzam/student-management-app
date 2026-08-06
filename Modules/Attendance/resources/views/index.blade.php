<x-layouts::app :title="'Attendance'">

    <div class="max-w-5xl mx-auto py-10 px-4">

        <h1 class="text-2xl font-bold mb-6">Attendance</h1>

        @if(session('success'))
            <div class="mb-4 rounded-lg bg-green-100 p-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-lg border p-6 mb-8">

            <form action="{{ route('attendance.store') }}" method="POST">
                @csrf

                <div class="grid gap-4 md:grid-cols-3">

                    <select name="student_id" class="rounded-lg border p-2" required>
                        <option value="">Select Student</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>

                    <input
                        type="date"
                        name="attendance_date"
                        class="rounded-lg border p-2"
                        required>

                    <select name="status" class="rounded-lg border p-2" required>
                        <option>Present</option>
                        <option>Absent</option>
                        <option>Late</option>
                    </select>

                </div>

                <div class="mt-4">
                    <flux:button type="submit" variant="primary">
                        Record Attendance
                    </flux:button>
                </div>

            </form>

        </div>

        <table class="min-w-full border">
            <thead>
                <tr class="border-b">
                    <th class="p-3 text-left">Student</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($attendances as $attendance)
                    <tr class="border-b">
                        <td class="p-3">{{ $attendance->student?->name ?? '-' }}</td>
                        <td class="p-3">{{ $attendance->attendance_date }}</td>
                        <td class="p-3">{{ $attendance->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-4 text-center text-gray-500">
                            No attendance records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</x-layouts::app>

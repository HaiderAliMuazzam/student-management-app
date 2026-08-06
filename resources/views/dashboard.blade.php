<x-layouts::app :title="__('Dashboard')">

    {{-- Dashboard overview --}}
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-5">

        {{-- Summary cards --}}
        <div class="rounded-xl border p-6">
            <p class="text-sm text-gray-500">Students</p>
            <h2 class="mt-2 text-3xl font-bold">{{ $studentCount }}</h2>
        </div>

        <div class="rounded-xl border p-6">
            <p class="text-sm text-gray-500">Subjects</p>
            <h2 class="mt-2 text-3xl font-bold">{{ $subjectCount }}</h2>
        </div>

        <div class="rounded-xl border p-6">
            <p class="text-sm text-gray-500">Grades</p>
            <h2 class="mt-2 text-3xl font-bold">{{ $gradeCount }}</h2>
        </div>

        <div class="rounded-xl border p-6">
            <p class="text-sm text-gray-500">Announcements</p>
            <h2 class="mt-2 text-3xl font-bold">{{ $announcementCount }}</h2>
        </div>

        <div class="rounded-xl border p-6">
            <p class="text-sm text-gray-500">Outstanding Amount</p>
            <h2 class="mt-2 text-3xl font-bold">
                PKR {{ number_format($outstandingAmount, 2) }}
            </h2>
        </div>

    </div>

</x-layouts::app>
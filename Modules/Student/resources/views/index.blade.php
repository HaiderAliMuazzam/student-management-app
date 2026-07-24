<x-layouts::app :title="'Students'">
    <div class="max-w-3xl mx-auto py-10 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Students</h1>
            @can('manage-students')
                <a href="/students/trashed" class="text-sm text-gray-600 dark:text-zinc-300 hover:underline">
                    View Trashed
                </a>
            @endcan
        </div>

        <form method="GET" action="/students" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search by name"
        class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

    <select name="grade" class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2">
        <option value="">All Grades</option>
        @foreach ($grades as $grade)
            <option value="{{ $grade }}" @selected(($filters['grade'] ?? '') === $grade)>{{ $grade }}</option>
        @endforeach
    </select>

    <select name="subject" class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2">
        <option value="">All Subjects</option>
        @foreach ($subjects as $subject)
            <option value="{{ $subject }}" @selected(($filters['subject'] ?? '') === $subject)>{{ $subject }}</option>
        @endforeach
    </select>

    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">
        Filter
    </button>
    <a href="/students" class="bg-gray-200 dark:bg-zinc-700 text-gray-800 dark:text-white px-4 py-2 rounded-md hover:bg-gray-300 transition">
        Reset
    </a>
</form>

@if ($errors->any())
    <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@can('manage-students')
        <form method="POST" action="/students" class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6 mb-8 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <input type="text" name="name" placeholder="Name"
                    class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="grade" placeholder="Grade"
                    class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="subject" placeholder="Subject"
                    class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="text" name="contact_number" placeholder="Contact Number" maxlength="15" inputmode="numeric"
                    class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Add Student
            </button>
        </form>
@endcan

        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 dark:bg-zinc-700 text-gray-600 dark:text-zinc-300 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Grade</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3">Contact</th>
                        @canany(['manage-students', 'delete-student'])
                            <th class="px-4 py-3">Actions</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                    @foreach ($students as $student)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700">
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $student->name }}</td>
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $student->grade }}</td>
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $student->subject }}</td>
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $student->contact_number }}</td>
                            @canany(['manage-students', 'delete-student'])
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        @can('manage-students')
                                            <a href="/students/{{ $student->id }}/edit"
                                                class="text-blue-600 hover:underline text-sm font-medium">
                                                Edit
                                            </a>
                                        @endcan
                                        @can('delete-student')
                                            <form method="POST" action="/students/{{ $student->id }}" onsubmit="return confirm('Delete this student?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline text-sm font-medium">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            @endcanany
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
    <div id="student-toast" class="fixed bottom-6 right-6 hidden bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 z-50"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Echo.channel('students')
                .listen('.student.created', (e) => {
                    const toast = document.getElementById('student-toast');
                    toast.textContent = `New student added: ${e.name}`;
                    toast.classList.remove('hidden', 'opacity-0');
                    setTimeout(() => {
                        toast.classList.add('opacity-0');
                        setTimeout(() => toast.classList.add('hidden'), 500);
                    }, 3000);
                });
        });
    </script>
</x-layouts::app>
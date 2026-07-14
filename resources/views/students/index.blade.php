<x-layouts::app :title="'Students'">
    <div class="max-w-3xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Students</h1>
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
                <input type="text" name="contact_number" placeholder="Contact Number"
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
    </div>
</x-layouts::app>
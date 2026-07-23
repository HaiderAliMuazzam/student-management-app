<x-layouts::app :title="'Trashed Students'">
    <div class="max-w-3xl mx-auto py-10 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Trashed Students</h1>
            <a href="/students" class="text-blue-600 hover:underline text-sm font-medium">
                Back to Students
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100 dark:bg-zinc-700 text-gray-600 dark:text-zinc-300 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Grade</th>
                        <th class="px-4 py-3">Subject</th>
                        <th class="px-4 py-3">Contact</th>
                        <th class="px-4 py-3">Deleted At</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse ($students as $student)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700">
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $student->name }}</td>
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $student->grade }}</td>
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $student->subject }}</td>
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $student->contact_number }}</td>
                            <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $student->deleted_at->format('M d, Y') }}</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="/students/{{ $student->id }}/restore" onsubmit="return confirm('Restore this student?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-green-600 hover:underline text-sm font-medium">
                                        Restore
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-zinc-400">
                                No deleted students.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
</x-layouts::app>
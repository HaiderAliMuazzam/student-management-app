<x-layouts::app :title="'Announcements'">

    {{-- 
        ===============================================================
        Announcements Page
        ===============================================================
        Why do we keep everything on one page?
        --------------------------------------
        For simple lookup/core modules, having the list and create form
        together provides a better user experience and avoids the need
        for separate create/edit pages.
    --}}

    <div class="max-w-5xl mx-auto py-10 px-4">

        {{-- Page Heading --}}
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            Announcements
        </h1>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-300 bg-red-100 px-4 py-3 text-red-800">
                <p class="font-semibold mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Create Announcement Form --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">
                Create Announcement
            </h2>

            <form action="{{ route('announcements.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Body</label>
                    <textarea id="body" name="body" rows="4" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('body') }}</textarea>
                </div>

                <flux:button type="submit" variant="primary">
                    Create Announcement
                </flux:button>
            </form>
        </div>

        {{-- Announcements Table --}}
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Body</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Created</th>
                        {{-- new: actions column --}}
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white dark:bg-gray-800">
                    @forelse($announcements as $announcement)
                        <tr>
                            <td class="px-6 py-4">{{ $announcement->id }}</td>
                            <td class="px-6 py-4 font-medium">{{ $announcement->title }}</td>
                            <td class="px-6 py-4">{{ $announcement->body }}</td>
                            <td class="px-6 py-4">{{ $announcement->created_at->format('d M Y') }}</td>
                            {{-- new: edit link + delete form --}}
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('announcements.edit', $announcement->id) }}"
                                    class="text-blue-600 hover:underline">Edit</a>

                                <form method="POST" action="{{ route('announcements.destroy', $announcement->id) }}"
                                    class="inline" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                No announcements available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-layouts::app>
<x-layouts::app :title="'Edit Announcement'">
    {{--
        ===============================================================
        Edit Announcement Page
        ===============================================================
        Why a separate edit page instead of inline like create?
        ------------------------------------------------------------
        Editing needs the existing record's data pre-filled and posts
        to a different route (update, not store), so it's cleaner as
        its own page rather than cramming into the index table.
    --}}
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
            Edit Announcement
        </h1>
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
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form action="{{ route('announcements.update', $announcement->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $announcement->title) }}" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="mb-4">
                    <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Body</label>
                    <textarea id="body" name="body" rows="4" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-indigo-500">{{ old('body', $announcement->body) }}</textarea>
                </div>
                <div class="flex gap-3">
                    <flux:button type="submit" variant="primary">
                        Save Changes
                    </flux:button>
                    <a href="{{ route('announcements.index') }}"
                        class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                        Cancel
                    </a>
                </div>
            </form>

            {{-- Attachments --}}
            <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
                    Attachments
                </h2>
                @include('attachment::_upload_form', ['attachable' => $announcement])
                @include('attachment::_list', ['attachable' => $announcement])
            </div>
        </div>
    </div>
</x-layouts::app>
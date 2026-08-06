{{-- File: Modules/Grade/resources/views/edit.blade.php --}}
{{-- Grade Module - Edit --}}
<x-layouts::app :title="__('grade::grades.edit')">
    <div class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">{{ __('grade::grades.edit') }}</h1>

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Edit Grade form — same field as create, but PUT + pre-filled value --}}
        <form method="POST" action="/grades/{{ $grade->id }}" class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6 flex gap-3">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ old('name', $grade->name) }}"
                placeholder="{{ __('grade::grades.grade_name') }}"
                class="flex-1 border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                {{ __('grade::grades.save') }}
            </button>
            <a href="/grades" class="bg-gray-200 dark:bg-zinc-600 text-gray-800 dark:text-white px-4 py-2 rounded-md hover:bg-gray-300 dark:hover:bg-zinc-500 transition">
                {{ __('grade::grades.cancel') }}
            </a>
        </form>
    </div>
</x-layouts::app>
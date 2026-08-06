{{-- File: Modules/Grade/resources/views/index.blade.php --}}
{{-- Grade Module - Listing --}}
<x-layouts::app :title="__('grade::grades.grades')">
    <div class="max-w-2xl mx-auto py-10 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ __('grade::grades.grades') }}</h1>
        </div>
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
        {{-- Create Grade form --}}
        <form method="POST" action="/grades" class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6 mb-8 flex gap-3">
            @csrf
            <input type="text" name="name" maxlength="20" placeholder="{{ __('grade::grades.grade_name') }}"
                class="flex-1 border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                {{ __('grade::grades.add_grade') }}
            </button>
        </form>
        {{-- Grades list --}}
        @if ($grades->isEmpty())
            <p class="text-gray-600 dark:text-zinc-300">{{ __('grade::grades.no_grades_found') }}</p>
        @else
            <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-100 dark:bg-zinc-700 text-gray-600 dark:text-zinc-300 text-sm uppercase">
                        <tr>
                            <th class="px-4 py-3">{{ __('grade::grades.name') }}</th>
                            {{-- new: actions column --}}
                            <th class="px-4 py-3 text-right">{{ __('grade::grades.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @foreach ($grades as $grade)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700">
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $grade->name }}</td>
                                {{-- new: edit link + delete form, same row --}}
                                <td class="px-4 py-3 text-right space-x-2">
                                    <a href="/grades/{{ $grade->id }}/edit"
                                        class="text-blue-600 hover:underline">{{ __('grade::grades.edit') }}</a>

                                    <form method="POST" action="/grades/{{ $grade->id }}" class="inline"
                                        onsubmit="return confirm('{{ __('grade::grades.confirm_delete') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:underline">{{ __('grade::grades.delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts::app>
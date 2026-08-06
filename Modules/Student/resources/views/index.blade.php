<x-layouts::app :title="__('student::students.students')">

<div class="max-w-3xl mx-auto py-10 px-4">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
            {{ __('student::students.students') }}
        </h1>

        @can('manage-students')
            <a href="/students/trashed"
               class="text-sm text-gray-600 dark:text-zinc-300 hover:underline">
                {{ __('student::students.trashed_students') }}
            </a>
        @endcan

    </div>


    {{-- Filters --}}
    <form method="GET" action="/students" class="flex flex-wrap gap-3 mb-6">

        <input type="text"
               name="search"
               value="{{ $filters['search'] ?? '' }}"
               placeholder="{{ __('student::students.search_name') }}"
               class="border rounded-md px-3 py-2 dark:bg-zinc-700 dark:text-white">


        <select name="grade_id"
                class="border rounded-md px-3 py-2 dark:bg-zinc-700 dark:text-white">

            <option value="">
                {{ __('student::students.all_grades') }}
            </option>

            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}"
                    @selected(($filters['grade_id'] ?? '') == $grade->id)>
                    {{ $grade->name }}
                </option>
            @endforeach

        </select>


        <select name="subject_id"
                class="border rounded-md px-3 py-2 dark:bg-zinc_700 dark:text-white">

            <option value="">
                {{ __('student::students.all_subjects') }}
            </option>

            @foreach ($subjects as $subject)

                <option value="{{ $subject->id }}"
                    @selected(($filters['subject_id'] ?? '') == $subject->id)>
                    {{ $subject->name }}
                </option>

            @endforeach

        </select>


        <button type="submit"
                class="bg-gray-700 text-white px-4 py-2 rounded-md">

            {{ __('student::students.filter') }}

        </button>


        <a href="/students"
           class="bg-gray-200 dark:bg-zinc-700 px-4 py-2 rounded-md">

            {{ __('student::students.reset') }}

        </a>

    </form>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">

            <ul class="list-disc list-inside">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- Create Student --}}
    @can('manage-students')

    <form method="POST"
          action="/students"
          class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6 mb-8 space-y-4">

        @csrf

        <div class="grid grid-cols-2 gap-4">


            <input type="text"
                   name="name"
                   placeholder="{{ __('student::students.name') }}"
                   class="border rounded-md px-3 py-2 dark:bg-zinc-700 dark:text-white">


            <select name="grade_id"
                    required
                    class="border rounded-md px-3 py-2 dark:bg-zinc-700 dark:text-white">

                <option value="">
                    {{ __('student::students.select_grade') }}
                </option>

                @foreach ($grades as $grade)

                    <option value="{{ $grade->id }}">
                        {{ $grade->name }}
                    </option>

                @endforeach

            </select>


            <select name="subject_id"
                    required
                    class="border rounded-md px-3 py-2 dark:bg-zinc-700 dark:text-white">

                <option value="">
                    {{ __('student::students.select_subject') }}
                </option>

                @foreach ($subjects as $subject)

                    <option value="{{ $subject->id }}">
                        {{ $subject->name }}
                    </option>

                @endforeach

            </select>


            <input type="text"
                   name="contact_number"
                   placeholder="{{ __('student::students.contact_number') }}"
                   maxlength="15"
                   class="border rounded-md px-3 py-2 dark:bg-zinc-700 dark:text-white">

        </div>


        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-md">

            {{ __('student::students.add_student') }}

        </button>

    </form>

    @endcan



    {{-- Students Table --}}
    <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">

        <table class="w-full text-left">

            <thead class="bg-gray-100 dark:bg-zinc-700">

                <tr>

                    <th class="px-4 py-3">{{ __('student::students.name') }}</th>
                    <th class="px-4 py-3">{{ __('student::students.grade') }}</th>
                    <th class="px-4 py-3">{{ __('student::students.subject') }}</th>
                    <th class="px-4 py-3">{{ __('student::students.contact_number') }}</th>

                    @canany(['manage-students','delete-student'])

                        <th class="px-4 py-3">
                            {{ __('student::students.actions') }}
                        </th>

                    @endcanany

                </tr>

            </thead>


            <tbody class="divide-y">

            @foreach ($students as $student)

                <tr>

                    <td class="px-4 py-3">
                        {{ $student->name }}
                    </td>


                    <td class="px-4 py-3">
                        {{ $student->grade?->name ?? '-' }}
                    </td>


                    <td class="px-4 py-3">
                        {{ $student->subject?->name ?? '-' }}
                    </td>


                    <td class="px-4 py-3">
                        {{ $student->contact_number }}
                    </td>


                    @canany(['manage-students','delete-student'])

                    <td class="px-4 py-3">

                        @can('manage-students')

                            <a href="/students/{{ $student->id }}/edit"
                               class="text-blue-600 hover:underline">

                                {{ __('student::students.edit') }}

                            </a>

                        @endcan


                        @can('delete-student')

                            <form method="POST"
                                  action="/students/{{ $student->id }}"
                                  class="inline">

                                @csrf
                                @method('DELETE')

                                <button class="text-red-600 ml-2">

                                    {{ __('student::students.delete') }}

                                </button>

                            </form>

                        @endcan

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


<div id="student-toast"
     class="fixed bottom-6 right-6 hidden bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg">
</div>


<script>

document.addEventListener('DOMContentLoaded', () => {

    Echo.channel('students')
        .listen('.student.created', (e) => {

            const toast = document.getElementById('student-toast');

            toast.textContent = `New student added: ${e.name}`;

            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);

        });

});

</script>


</x-layouts::app>
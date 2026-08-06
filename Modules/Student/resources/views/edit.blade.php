{{-- Master Layout Component: Wraps the page in the core app layout shell --}}
<x-layouts::app :title="'Edit Student'">

    <div class="max-w-3xl mx-auto py-10 px-4">

        {{-- Section Title --}}
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Edit Student</h1>

        {{-- 
            Validation Error Container:
            $errors->any() checks if the validator injected any error messages into the session.
        --}}
        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    {{-- Loop through each validation error string and display in an un-ordered list --}}
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 
            Update Form:
            Submits a POST request targeting StudentController@update for the specified student ID.
        --}}
        <form method="POST" action="/students/{{ $student->id }}" class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6 space-y-4">
            
            {{-- CSRF Token Directive: Protects against Cross-Site Request Forgery attacks --}}
            @csrf

            {{-- Method Spoofing: HTML forms only support GET/POST; @method('PUT') instructs Laravel to route this as a PUT request --}}
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">

                {{-- 
                    Student Name Field:
                    old('name', $student->name) pre-fills with old input if validation failed, 
                    otherwise defaults to the existing database record value.
                --}}
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $student->name) }}" 
                       placeholder="Name"
                       class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                {{-- Grade Input Field --}}
                <input type="text" 
                       name="grade" 
                       value="{{ old('grade', $student->grade) }}" 
                       placeholder="Grade"
                       class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                {{-- Subject Input Field --}}
                <input type="text" 
                       name="subject" 
                       value="{{ old('subject', $student->subject) }}" 
                       placeholder="Subject"
                       class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                {{-- Contact Number Field --}}
                <input type="text" 
                       name="contact_number" 
                       value="{{ old('contact_number', $student->contact_number) }}" 
                       placeholder="Contact Number"
                       class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

            </div>

            {{-- Form Submission & Navigation Actions --}}
            <div class="flex gap-3">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    Update Student
                </button>

                <a href="/students"
                    class="bg-gray-200 dark:bg-zinc-700 text-gray-800 dark:text-white px-4 py-2 rounded-md hover:bg-gray-300 dark:hover:bg-zinc-600 transition">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</x-layouts::app>
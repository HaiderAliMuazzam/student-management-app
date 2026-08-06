{{-- Finance Module - Edit Invoice --}}
<x-layouts::app :title="'Edit Invoice'">
    <div class="max-w-2xl mx-auto py-10 px-4">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Invoice</h1>
            <a href="/invoices" class="text-sm text-gray-600 dark:text-zinc-300 hover:underline">
                Back to Invoices
            </a>
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

        {{-- Edit form. Uses @method('PUT') to spoof a PUT request over POST,
             since HTML forms don't support PUT natively. Matches the route
             we defined: PUT /invoices/{invoice} --}}
        <form method="POST" action="/invoices/{{ $invoice->id }}" class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Student</label>
                <select name="student_id" class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2">
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @selected($invoice->student_id === $student->id)>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $invoice->title) }}"
                    class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Amount</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount', $invoice->amount) }}"
                    class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-zinc-300 mb-1">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}"
                    class="w-full border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Read-only display of status and amount_paid — these aren't
                 editable here since Payment will manage them later. --}}
            <div class="grid grid-cols-2 gap-4 pt-2 border-t border-gray-200 dark:border-zinc-700">
                <div>
                    <span class="block text-sm font-medium text-gray-500 dark:text-zinc-400">Status</span>
                    <span class="text-gray-900 dark:text-white">{{ ucfirst($invoice->status->value) }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 dark:text-zinc-400">Amount Paid</span>
                    <span class="text-gray-900 dark:text-white">{{ number_format($invoice->amount_paid, 2) }}</span>
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Save Changes
            </button>
        </form>

    </div>
</x-layouts::app>
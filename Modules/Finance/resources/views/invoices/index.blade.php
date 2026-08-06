{{-- Finance Module - Invoice Listing --}}
<x-layouts::app :title="'Invoices'">
    <div class="max-w-4xl mx-auto py-10 px-4">

         {{-- Page heading with links to trashed invoices and payments --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Invoices</h1>
            <div class="flex gap-4">
                <a href="/payments" class="text-sm text-gray-600 dark:text-zinc-300 hover:underline">
                    View Payments
                </a>
                <a href="/invoices/trashed" class="text-sm text-gray-600 dark:text-zinc-300 hover:underline">
                    View Trashed
                </a>
            </div>
        </div>

        {{-- Filter form: filters invoices by student or status via GET query params --}}
        <form method="GET" action="/invoices" class="flex flex-wrap gap-3 mb-6">
            <select name="student_id" class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2">
                <option value="">All Students</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}" @selected(($filters['student_id'] ?? '') == $student->id)>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2">
                <option value="">All Statuses</option>
                @foreach (\Modules\Finance\Enums\InvoiceStatus::cases() as $status)
                    <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>
                        {{ ucfirst($status->value) }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">
                Filter
            </button>
            <a href="/invoices" class="bg-gray-200 dark:bg-zinc-700 text-gray-800 dark:text-white px-4 py-2 rounded-md hover:bg-gray-300 transition">
                Reset
            </a>
        </form>

        {{-- Validation errors, same pattern as Student index --}}
        @if ($errors->any())
            <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Create Invoice form --}}
        <form method="POST" action="/invoices" class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6 mb-8 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <select name="student_id" class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2">
                    <option value="">Select Student</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="title" placeholder="Invoice Title"
                    class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="number" step="0.01" name="amount" placeholder="Amount"
                    class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="date" name="due_date"
                    class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Add Invoice
            </button>
        </form>

        {{-- Invoices table, or an empty-state message --}}
        @if ($invoices->isEmpty())
            <p class="text-gray-600 dark:text-zinc-300">No invoices found.</p>
        @else
            <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-100 dark:bg-zinc-700 text-gray-600 dark:text-zinc-300 text-sm uppercase">
                        <tr>
                            <th class="px-4 py-3">Student</th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Amount</th>
                            <th class="px-4 py-3">Paid</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Due Date</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @foreach ($invoices as $invoice)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700">
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $invoice->student?->name }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $invoice->title }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ number_format($invoice->amount, 2) }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ number_format($invoice->amount_paid, 2) }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ ucfirst($invoice->status->value) }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $invoice->due_date?->format('Y-m-d') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-2">
                                        <a href="/invoices/{{ $invoice->id }}/edit" class="text-blue-600 hover:underline text-sm font-medium">
                                            Edit
                                        </a>
                                        {{-- Soft-delete form. Uses @method('DELETE') to spoof
                                             a DELETE request, matching the destroy route. --}}
                                        <form method="POST" action="/invoices/{{ $invoice->id }}" onsubmit="return confirm('Delete this invoice?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm font-medium">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination links --}}
            <div class="mt-4">
                {{ $invoices->links() }}
            </div>
        @endif

    </div>
</x-layouts::app>
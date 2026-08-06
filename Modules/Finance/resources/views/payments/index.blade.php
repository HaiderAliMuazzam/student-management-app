{{-- Finance Module - Payment Listing --}}
<x-layouts::app :title="'Payments'">
    <div class="max-w-4xl mx-auto py-10 px-4">

        {{-- Page heading --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Payments</h1>
            <a href="/invoices" class="text-sm text-gray-600 dark:text-zinc-300 hover:underline">
                Back to Invoices
            </a>
        </div>

        {{-- Filter form: filters payments by invoice via GET query params --}}
        <form method="GET" action="/payments" class="flex flex-wrap gap-3 mb-6">
            <select name="invoice_id" class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2">
                <option value="">All Invoices</option>
                @foreach ($invoices as $invoice)
                    <option value="{{ $invoice->id }}" @selected(($filters['invoice_id'] ?? '') == $invoice->id)>
                        {{ $invoice->title }} ({{ $invoice->student?->name }})
                    </option>
                @endforeach
            </select>

            <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">
                Filter
            </button>
            <a href="/payments" class="bg-gray-200 dark:bg-zinc-700 text-gray-800 dark:text-white px-4 py-2 rounded-md hover:bg-gray-300 transition">
                Reset
            </a>
        </form>

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

        {{-- Record Payment form --}}
        <form method="POST" action="/payments" class="bg-white dark:bg-zinc-800 shadow rounded-lg p-6 mb-8 space-y-4">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <select name="invoice_id" class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2">
                    <option value="">Select Invoice</option>
                    @foreach ($invoices as $invoice)
                        <option value="{{ $invoice->id }}">
                            {{ $invoice->title }} ({{ $invoice->student?->name }}) — Owed: {{ number_format($invoice->amount - $invoice->amount_paid, 2) }}
                        </option>
                    @endforeach
                </select>
                <input type="number" step="0.01" name="amount" placeholder="Amount"
                    class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <input type="date" name="paid_at"
                    class="border border-gray-300 dark:border-zinc-600 dark:bg-zinc-700 dark:text-white rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Record Payment
            </button>
        </form>

        {{-- Payments table. No Edit/Delete actions — payments are immutable
             once created, matching a real payment ledger. --}}
        @if ($payments->isEmpty())
            <p class="text-gray-600 dark:text-zinc-300">No payments found.</p>
        @else
            <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-100 dark:bg-zinc-700 text-gray-600 dark:text-zinc-300 text-sm uppercase">
                        <tr>
                            <th class="px-4 py-3">Invoice</th>
                            <th class="px-4 py-3">Student</th>
                            <th class="px-4 py-3">Amount</th>
                            <th class="px-4 py-3">Paid On</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-700">
                        @foreach ($payments as $payment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700">
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $payment->invoice?->title }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $payment->invoice?->student?->name }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $payment->paid_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination links --}}
            <div class="mt-4">
                {{ $payments->links() }}
            </div>
        @endif

    </div>
</x-layouts::app>
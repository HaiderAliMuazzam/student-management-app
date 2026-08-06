{{-- Finance Module - Trashed Invoices --}}
<x-layouts::app :title="'Trashed Invoices'">
    <div class="max-w-4xl mx-auto py-10 px-4">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Trashed Invoices</h1>
            <a href="/invoices" class="text-sm text-gray-600 dark:text-zinc-300 hover:underline">
                Back to Invoices
            </a>
        </div>

        @if ($invoices->isEmpty())
            <p class="text-gray-600 dark:text-zinc-300">No trashed invoices.</p>
        @else
            <div class="bg-white dark:bg-zinc-800 shadow rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-100 dark:bg-zinc-700 text-gray-600 dark:text-zinc-300 text-sm uppercase">
                        <tr>
                            <th class="px-4 py-3">Student</th>
                            <th class="px-4 py-3">Title</th>
                            <th class="px-4 py-3">Amount</th>
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
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ ucfirst($invoice->status->value) }}</td>
                                <td class="px-4 py-3 text-gray-900 dark:text-white">{{ $invoice->due_date?->format('Y-m-d') }}</td>
                                <td class="px-4 py-3">
                                    {{-- Restore form. Uses @method('PATCH') to match the
                                         restore route: PATCH /invoices/{id}/restore --}}
                                    <form method="POST" action="/invoices/{{ $invoice->id }}/restore">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-green-600 hover:underline text-sm font-medium">
                                            Restore
                                        </button>
                                    </form>
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
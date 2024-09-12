<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Analytics Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-6">
                <!-- Total Invoices Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-200 text-lg">Total Invoices</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalInvoices }}</div>
                </div>

                <!-- Unpaid Invoices Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-200 text-lg">Unpaid Invoices</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $unpaidInvoices }}</div>
                </div>

                <!-- Total Balance Due Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-200 text-lg">Total Balance Due</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalBalanceDue, 2) }} DH</div>
                </div>

                <!-- Total Payments This Month Card -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="text-gray-500 dark:text-gray-200 text-lg">Total Payments (This Month)</div>
                    <div class="mt-2 text-3xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalPaymentsThisMonth, 2) }} DH</div>
                </div>
            </div>

            <!-- List of Unpaid Invoices -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200 mb-4">Unpaid Invoices</h3>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-200">
                                Customer
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-200">
                                Invoice Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase dark:text-gray-200">
                                Balance Due
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        @foreach ($unpaidInvoicesList as $invoice)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->customer->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ number_format($invoice->balance_due, 2) }} DH</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- List of Random Customers with Balance Due -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200 mb-4">Random Customers with Balance Due</h3>
                <ul>
                    @foreach ($customersWithBalance as $customer)
                        <li class="text-gray-800 dark:text-gray-200 mb-2">{{ $customer->name }} (Balance Due: {{ number_format($customer->invoices->sum('balance_due'), 2) }} DH)</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Customer Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <div class="grid grid-cols-2">
                    <!-- Customer Info -->
                    <div class="col-span-1 ">
                        <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                            {{ __('Customer Information') }}
                        </h3>
                        <div class="mt-4">
                            <p><strong>Name:</strong> {{ $customer->name }}</p>
                            <p><strong>Email:</strong> {{ $customer->email }}</p>
                            <p><strong>Phone:</strong> {{ $customer->phone_number }}</p>
                            <p><strong>Company Name:</strong> {{ $customer->company_name }}</p>
                            <p><strong>ICE:</strong> {{ $customer->ice }}</p>
                            <p><strong>Address:</strong> {{ $customer->address }}</p>
                        </div>
                    </div>
                    <div class="col-span-1 p-6 overflow-hidden bg-gray-200 border-2 border-gray-800 rounded-lg">
                        <!-- Total Balance Due -->
                        <h3 class="mt-8 text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                            {{ __('Total Balance Due') }}
                        </h3>
                        <div class="mt-4">
                            <p class="text-lg font-semibold">{{ $totalBalanceDue }} Dh</p>
                        </div>
                    </div>
                </div>
                <!-- Associated Vehicles -->
                <h3 class="mt-8 text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Associated Vehicles') }}
                </h3>
                <div class="mt-4">
                    @if ($customer->vehicles->count())
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Brand
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Model
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        License Plate
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($customer->vehicles as $vehicle)
                                    <tr>
                                        <td class="px-6 py-4">{{ $vehicle->brand }}</td>
                                        <td class="px-6 py-4">{{ $vehicle->model }}</td>
                                        <td class="px-6 py-4">{{ $vehicle->license_plate }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No vehicles associated with this customer.</p>
                    @endif
                </div>

                <!-- Associated Invoices -->
                <h3 class="mt-8 text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Associated Invoices') }}
                </h3>
                <div class="mt-4">
                    @if ($customer->invoices->count())
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Invoice ID
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Invoice Date
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Total Amount
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Amount Paid
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Balance Due
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($customer->invoices as $invoice)
                                    <tr>
                                        <td class="px-6 py-4">{{ $invoice->invoice_id }}</td>
                                        <td class="px-6 py-4">{{ $invoice->invoice_date }}</td>
                                        <td class="px-6 py-4">{{ $invoice->total_amount }} Dh</td>
                                        <td class="px-6 py-4">{{ $invoice->amount_paid }} Dh</td>
                                        <td class="px-6 py-4">{{ $invoice->balance_due }} Dh</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold text-white bg-{{ $invoice->status === 'paid' ? 'green' : ($invoice->status === 'partially_paid' ? 'yellow' : 'red') }}-600  rounded-full">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No invoices associated with this customer.</p>
                    @endif
                </div>



                <!-- Payment History -->
                <h3 class="mt-8 text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ __('Payment History') }}
                </h3>
                <div class="mt-4">
                    @if ($paymentHistory->count())
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Invoice ID
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Payment Date
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Payment Amount
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Payment Method
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($paymentHistory as $payment)
                                    <tr>
                                        <td class="px-6 py-4">{{ $payment->invoice->invoice_id }}</td>
                                        <td class="px-6 py-4">{{ $payment->payment_date }}</td>
                                        <td class="px-6 py-4">{{ $payment->amount }} Dh</td>
                                        <td class="px-6 py-4">{{ ucfirst($payment->payment_method) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-gray-500">No payment history available.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

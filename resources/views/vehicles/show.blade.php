<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Vehicle Details') }} - {{ $vehicle->brand }} ({{ $vehicle->license_plate }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                
                <!-- Vehicle Information -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        {{ __('Vehicle Information') }}
                    </h3>
                    <p><strong>Brand:</strong> {{ $vehicle->brand }}</p>
                    <p><strong>Model:</strong> {{ $vehicle->model }}</p>
                    <p><strong>License Plate:</strong> {{ $vehicle->license_plate }}</p>
                    <p><strong>Year:</strong> {{ $vehicle->year }}</p>
                </div>

                <!-- Vehicle Histories -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        {{ __('Vehicle History') }}
                    </h3>
                    <div class="mt-4">
                        @if ($vehicle->histories->count())
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                            Description
                                        </th>
                                        <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                            Service Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    @foreach ($vehicle->histories as $history)
                                        <tr>
                                            <td class="px-6 py-4">{{ $history->description }}</td>
                                            <td class="px-6 py-4">{{ $history->service_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-gray-500">No history available for this vehicle.</p>
                        @endif
                    </div>
                </div>

                <!-- Related Invoices -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        {{ __('Related Invoices') }}
                    </h3>
                    <div class="mt-4">
                        @if ($vehicle->invoices->count())
                            <div class="space-y-6">
                                @foreach ($vehicle->invoices as $invoice)
                                    <div class="border-b pb-4">
                                        <p><strong>Invoice ID:</strong> {{ $invoice->invoice_id }}</p>
                                        <ul class="list-disc list-inside">
                                            @foreach ($invoice->items as $item)
                                                <li>{{ $item->description }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No invoices available for this vehicle.</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

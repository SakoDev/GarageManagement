<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Invoices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">

                <div class="mb-6">
                    <div class="flex justify-between">
                        <h3 class="mb-4 text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                            {{ __('Invoices') }}
                        </h3>
                        <x-button
                            class="flex items-center bg-slate-800 hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-700">
                            <a href="{{ route('invoices.create') }}" class="flex items-center">
                                <svg class="w-4 h-4 me-2 pe-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30">
                                    <path
                                        d="M14.970703 2.9726562 A 2.0002 2.0002 0 0 0 13 5L13 13L5 13 A 2.0002 2.0002 0 1 0 5 17L13 17L13 25 A 2.0002 2.0002 0 1 0 17 25L17 17L25 17 A 2.0002 2.0002 0 1 0 25 13L17 13L17 5 A 2.0002 2.0002 0 0 0 14.970703 2.9726562 z"
                                        fill="#fff" />
                                </svg>
                                <span>Create Invoice</span>
                            </a>
                        </x-button>
                    </div>

                    <div class="mt-5 overflow-x-auto">
                        <table class="w-full min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                                        Customer</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                                        Invoice Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                                        Rest to Pay</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                                        Total Amount</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-gray-200">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="">
                                                <p>{{ $invoice->customer->name }}</p>
                                                <p class="text-xs font-light text-stone-700">Car
                                                    :{{ $invoice->vehicle->license_plate }}</p>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->invoice_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->balance_due }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->total_amount }} Dh</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($invoice->status === 'paid')
                                                <span
                                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Paid</span>
                                            @elseif ($invoice->status === 'partially_paid')
                                                <span
                                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">Partially
                                                    Paid</span>
                                            @else
                                                <span
                                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">Unpaid</span>
                                            @endif
                                        </td>
                                        <td class="flex px-6 py-4 space-x-4 whitespace-nowrap">
                                            <a href="{{ route('invoices.edit', $invoice->id) }}"
                                                class="inline-flex items-center text-indigo-600 hover:text-indigo-900">
                                                <svg class="w-5 h-5 " xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 30 30">
                                                    <path
                                                        d="M24 11l2.414-2.414c.781-.781.781-2.047 0-2.828l-2.172-2.172c-.781-.781-2.047-.781-2.828 0L19 6 24 11zM17 8L5.26 19.74C7.886 19.427 6.03 21.933 7 23c.854.939 3.529-.732 3.26 1.74L22 13 17 8zM4.328 26.944l-.015-.007c-.605.214-1.527-.265-1.25-1.25l-.007-.015L4 23l3 3L4.328 26.944z"
                                                        fill="currentColor" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="inline-flex items-center text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this invoice?')">
                                                    <svg class="w-5 h-5 " xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M9.03125 -0.03125C8.566406 -0.03125 8.1875 0.347656 8.1875 0.8125L8.1875 3.6875C5.46875 3.996094 3.59375 4.621094 3.59375 5.34375L3.59375 6.71875C3.59375 7 3.894531 7.257813 4.40625 7.5C5.746094 8.128906 8.644531 8.5625 12 8.5625C15.359375 8.5625 18.25 8.128906 19.59375 7.5C20.101563 7.257813 20.40625 7 20.40625 6.71875L20.40625 5.34375C20.40625 4.597656 18.378906 3.949219 15.5 3.65625L15.5 0.8125C15.5 0.347656 15.121094 -0.03125 14.65625 -0.03125 Z M 9.875 1.5L13.84375 1.5C13.929688 1.5 13.96875 1.902344 13.96875 2.40625L13.96875 3.53125C13.332031 3.5 12.6875 3.46875 12 3.46875C11.289063 3.46875 10.59375 3.496094 9.9375 3.53125L9.71875 3.5625L9.71875 2.40625C9.71875 1.902344 9.792969 1.5 9.875 1.5 Z M 4.78125 9.53125C4.691406 9.625 4.644531 9.710938 4.625 9.8125L4.625 9.875C4.625 9.890625 4.621094 9.925781 4.625 9.9375L5.1875 21.6875C5.238281 22.609375 6.304688 24 12 24C17.695313 24 18.761719 22.609375 18.8125 21.6875L19.375 9.9375C19.375 9.921875 19.375 9.890625 19.375 9.875L19.375 9.8125C19.359375 9.710938 19.308594 9.625 19.21875 9.53125C18.484375 10.277344 15.527344 10.375 12 10.375C8.472656 10.375 5.519531 10.277344 4.78125 9.53125Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <!-- Print button -->
                                            <a href="{{ route('invoices.print', $invoice->id) }}"
                                                class="inline-flex items-center text-gray-600 hover:text-gray-900"
                                                target="_blank">
                                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path
                                                        d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2M6 14h12v8H6v-8z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

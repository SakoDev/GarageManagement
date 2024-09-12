<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <span class="text-lg text-black capitalize my-9"><strong>Invoice Id :</strong> <span
                        class="text-gray-300 ">{{ $invoice->invoice_id }}</span> </span>
                <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" oninput="calculateTotal()">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-6 mb-4 sm:grid-cols-2">
                        <!-- Customer -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Customer
                            </label>
                            <select name="customer_id" id="customer_id"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required onchange="fetchVehicles(this.value)">
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ $invoice->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Vehicle -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="vehicle_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Vehicle
                            </label>
                            <select name="vehicle_id" id="vehicle_id"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                                <option value="">Select Vehicle</option>
                                @foreach ($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}"
                                        {{ $invoice->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->brand }} - {{ $vehicle->license_plate }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicle_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Invoice Date -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="invoice_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Invoice Date
                            </label>
                            <input type="date" name="invoice_date" id="invoice_date"
                                value="{{ old('invoice_date', $invoice->invoice_date) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('invoice_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- VAT Rate -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="vat_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                VAT Rate (%)
                            </label>
                            <input type="number" name="vat_rate" id="vat_rate"
                                value="{{ old('vat_rate', $invoice->vat_rate) }}" step="0.01"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('vat_rate')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Invoice Items -->
                    <div class="col-span-2 mb-4 sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Invoice Items
                        </label>

                        <div id="invoice-items">
                            @foreach ($invoice->items as $item)
                                <div class="flex mb-2 invoice-item-row">
                                    <!-- Item Type Dropdown -->
                                    <select name="type[]"
                                        class="block w-1/4 px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>
                                        <option value="Unit" {{ $item->type == 'Unit' ? 'selected' : '' }}>Unit
                                        </option>
                                        <option value="Collection" {{ $item->type == 'Collection' ? 'selected' : '' }}>
                                            Collection</option>
                                        <option value="Km" {{ $item->type == 'Km' ? 'selected' : '' }}>Km</option>
                                        <option value="M" {{ $item->type == 'M' ? 'selected' : '' }}>M</option>
                                        <option value="Litre" {{ $item->type == 'Litre' ? 'selected' : '' }}>Litre
                                        </option>
                                        <option value="Piece" {{ $item->type == 'Piece' ? 'selected' : '' }}>Piece
                                        </option>
                                    </select>

                                    <!-- Item Description -->
                                    <input type="text" name="item_description[]" placeholder="Item description"
                                        class="block w-full px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        value="{{ $item->description }}" required>

                                    <!-- Quantity -->
                                    <input type="number" name="quantity[]" placeholder="Quantity" min="1"
                                        class="block w-1/4 px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        value="{{ $item->quantity }}" required>

                                    <!-- Unit Amount -->
                                    <input type="number" name="unit_amount[]" placeholder="Unit price" step="0.01"
                                        class="block w-1/4 px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        value="{{ $item->unit_amount }}" required>

                                    <!-- Remove Button -->
                                    <button type="button"
                                        class="px-3 py-2 ml-2 text-red-500 bg-transparent border border-red-500 rounded-md hover:bg-red-500 hover:text-white"
                                        onclick="removeInvoiceItem(this)">Remove</button>
                                </div>
                            @endforeach
                        </div>

                        <x-button type="button" class="mt-2" onclick="addInvoiceItem()">+ Add Item</x-button>
                    </div>

                    <!-- VAT Amount (TVA) and Total Amount -->
                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-2">
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="TVA" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                TVA (VAT Amount)
                            </label>
                            <input id="TVA" type="number" value="{{ $invoice->vat_amount }}" step="0.01"
                                readonly
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                            <label for="total_amount"
                                class="block mt-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                                Total Amount
                            </label>
                            <input type="number" name="total_amount" id="total_amount"
                                value="{{ $invoice->total_amount }}" step="0.01" readonly
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Payment History and Payment Form -->
                    <div class="grid grid-cols-2 gap-6 p-6 mb-4 border-2 rounded-lg sm:grid-cols-2">
                        <div class="col-span-2 m-4 sm:col-span-1">
                            <!-- Payment History -->
                            <h3 class="mt-8 text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                {{ __('Payment History') }}
                            </h3>

                            <div class="mt-4">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Payment
                                                Date</th>
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Amount
                                            </th>
                                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Method
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($invoice->payments as $payment)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->payment_date }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->amount }} Dh</td>
                                                <td class="px-6 py-4 whitespace-nowrap">{{ $payment->payment_method }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-span-2 m-4 sm:col-span-1">
                            <!-- Add New Payment -->
                            @if ($invoice->status !== 'paid')
                                <h3 class="mt-8 text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200">
                                    {{ __('Make a Payment') }} <span
                                        class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Rest to pay
                                        :{{ $invoice->balance_due }} DH</span>
                                </h3>

                                <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                                    <!-- Payment Amount -->
                                    <div>
                                        <label for="payment_amount"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-200">Payment
                                            Amount</label>
                                        <input type="number" name="payment_amount" id="payment_amount"
                                            step="0.01" min="0.01" max="{{ $invoice->balance_due }}"
                                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            required>
                                    </div>

                                    <!-- Payment Method -->
                                    <div>
                                        <label for="payment_method"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-200">Payment
                                            Method</label>
                                        <select name="payment_method" id="payment_method"
                                            class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="cash">Cash</option>
                                            <option value="credit_card">Credit Card</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>

                                <x-button class="mt-4">
                                    {{ __('Add Payment') }}
                                </x-button>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <x-button class="mr-2">
                            {{ __('Update Invoice') }}
                        </x-button>

                        <x-secondary-button type="button" onclick="window.location='{{ route('invoices.index') }}'">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // Function to add a new invoice item row
        function addInvoiceItem() {
            let itemsContainer = document.getElementById('invoice-items');
            let newItem = `
                <div class="flex mb-2 invoice-item-row">
                    <select name="type[]" class="block w-1/4 px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="Unit" selected>Unit</option>
                        <option value="Collection">Collection</option>
                        <option value="Km">Km</option>
                        <option value="M">M</option>
                        <option value="Litre">Litre</option>
                        <option value="Piece">Piece</option>
                    </select>

                    <input type="text" name="item_description[]" placeholder="Item description"
                        class="block w-full px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>

                    <input type="number" name="quantity[]" placeholder="Quantity" min="1" value="1"
                        class="block w-1/4 px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>

                    <input type="number" name="unit_amount[]" placeholder="Unit price" step="0.01"
                        class="block w-1/4 px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>

                    <button type="button" class="px-3 py-2 ml-2 text-red-500 bg-transparent border border-red-500 rounded-md hover:bg-red-500 hover:text-white"
                        onclick="removeInvoiceItem(this)">Remove</button>
                </div>
            `;
            itemsContainer.insertAdjacentHTML('beforeend', newItem);
        }

        // Function to remove an invoice item row
        function removeInvoiceItem(button) {
            const row = button.closest('.invoice-item-row');
            row.remove();
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            let vatRate = parseFloat(document.getElementById('vat_rate').value) || 0;

            // Calculate total for items
            document.querySelectorAll('#invoice-items .flex').forEach(item => {
                let quantity = parseFloat(item.querySelector('[name="quantity[]"]').value) || 0;
                let unitAmount = parseFloat(item.querySelector('[name="unit_amount[]"]').value) || 0;
                total += quantity * unitAmount;
            });

            // Calculate VAT amount
            let vatAmount = (total * vatRate) / 100;
            document.getElementById('TVA').value = vatAmount.toFixed(2);

            // Add VAT to the total
            total += vatAmount;
            document.getElementById('total_amount').value = total.toFixed(2);
        }

        // Call calculateTotal to update totals on page load
        window.onload = calculateTotal;
    </script>
</x-app-layout>

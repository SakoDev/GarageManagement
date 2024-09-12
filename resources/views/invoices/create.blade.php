<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Create Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">

                <form action="{{ route('invoices.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-2">
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
                                    <option value="{{ $customer->id }}">
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
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
                                <!-- Vehicles will be populated dynamically -->
                            </select>
                        </div>

                        <!-- Invoice Date -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="invoice_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Invoice Date
                            </label>
                            <input type="date" name="invoice_date" id="invoice_date"
                                value="{{ old('invoice_date') }}"
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
                            <input type="number" name="vat_rate" id="vat_rate" value="{{ old('vat_rate', 0) }}"
                                step="0.01"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                oninput="calculateTotal()">
                            @error('vat_rate')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status Dropdown -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Status
                            </label>
                            <select name="status" id="status"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required onchange="toggleAmountPaid()">
                                <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid
                                </option>
                                <option value="partially_paid"
                                    {{ old('status') == 'partially_paid' ? 'selected' : '' }}>
                                    Partially Paid</option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount Paid (Hidden by default) -->
                        <div class="col-span-2 mb-4 sm:col-span-1" id="amount-paid-field" style="display: none;">
                            <label for="amount_paid" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                Amount Paid
                            </label>
                            <input type="number" name="amount_paid" id="amount_paid"
                                value="{{ old('amount_paid', 0) }}" step="0.01"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('amount_paid')
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
                            <div class="flex mb-2 invoice-item-row">
                                <!-- Item Type Dropdown -->
                                <select name="type[]"
                                    class="block w-1/4 px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>
                                    <option value="Unit" selected>Unit</option>
                                    <option value="Collection">Collection</option>
                                    <option value="Km">Km</option>
                                    <option value="M">M</option>
                                    <option value="Litre">Litre</option>
                                    <option value="Piece">Piece</option>
                                </select>

                                <!-- Item Description -->
                                <input type="text" name="item_description[]" placeholder="Item description"
                                    class="block w-full px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    required>

                                <!-- Quantity -->
                                <input type="number" name="quantity[]" placeholder="Quantity" min="1"
                                    value="1"
                                    class="block w-1/4 px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    oninput="calculateTotal()" required>

                                <!-- Unit Amount -->
                                <input type="number" name="unit_amount[]" placeholder="Unit price" step="0.01"
                                    class="block w-1/4 px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    oninput="calculateTotal()" required>

                                <!-- Remove Button -->
                                <button type="button"
                                    class="px-3 py-2 ml-2 text-red-500 bg-transparent rounded-md hover:text-white"
                                    onclick="removeInvoiceItem(this)">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                        <path
                                            d="M24,4C12.972,4,4,12.972,4,24s8.972,20,20,20s20-8.972,20-20S35.028,4,24,4z M32.5,25.5h-17c-0.829,0-1.5-0.671-1.5-1.5s0.671-1.5,1.5-1.5h17c0.829,0,1.5,0.671,1.5,1.5S33.329,25.5,32.5,25.5z"
                                            fill="currentColor" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <x-button type="button" class="mt-2" onclick="addInvoiceItem()">+ Add Item</x-button>

                        @error('item_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-2">
                        <!-- VAT Amount (TVA) -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="TVA" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                TVA (VAT Amount)
                            </label>
                            <input id="TVA" type="number" value="" step="0.01" readonly
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <label for="total_amount"
                                class="block mt-2 text-sm font-medium text-gray-700 dark:text-gray-200">
                                Total Amount
                            </label>
                            <input type="number" name="total_amount" id="total_amount"
                                value="{{ old('total_amount', 0) }}" step="0.01" readonly
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="mt-6">
                        <x-button class="mr-2">
                            {{ __('Create Invoice') }}
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
        function fetchVehicles(customerId) {
            const vehicleDropdown = document.getElementById('vehicle_id');
            vehicleDropdown.innerHTML = '<option value="">Loading...</option>'; // Show a loading message

            if (!customerId) {
                vehicleDropdown.innerHTML = '<option value="">Select Vehicle</option>';
                return;
            }

            // Send AJAX request to fetch vehicles associated with the selected customer
            fetch(`/get-vehicles/${customerId}`)
                .then(response => response.json())
                .then(data => {
                    vehicleDropdown.innerHTML = '<option value="">Select Vehicle</option>'; // Reset dropdown
                    data.forEach(vehicle => {
                        vehicleDropdown.innerHTML +=
                            `<option value="${vehicle.id}">${vehicle.brand} - ${vehicle.license_plate}</option>`;
                    });
                })
                .catch(error => {
                    vehicleDropdown.innerHTML = '<option value="">Error loading vehicles</option>';
                    console.error('Error fetching vehicles:', error);
                });
        }
        // Function to toggle the Amount Paid field based on status
        function toggleAmountPaid() {
            const status = document.getElementById('status').value;
            const amountPaidField = document.getElementById('amount-paid-field');
            if (status === 'partially_paid') {
                amountPaidField.style.display = 'block';
            } else {
                amountPaidField.style.display = 'none';
            }
        }

        function addInvoiceItem() {
            let itemsContainer = document.getElementById('invoice-items');
            let newItem = `
                <div class="flex mb-2 invoice-item-row">
                    <!-- Item Type Dropdown -->
                    <select name="type[]" class="block w-1/4 px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        <option value="Unit" selected>Unit</option>
                        <option value="Collection">Collection</option>
                        <option value="Km">Km</option>
                        <option value="M">M</option>
                        <option value="Litre">Litre</option>
                        <option value="Piece">Piece</option>
                    </select>

                    <!-- Item Description -->
                    <input type="text" name="item_description[]" placeholder="Item description"
                        class="block w-full px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>

                    <!-- Quantity -->
                    <input type="number" name="quantity[]" placeholder="Quantity" min="1" value="1"
                        class="block w-1/4 px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" oninput="calculateTotal()" required>

                    <!-- Unit Amount -->
                    <input type="number" name="unit_amount[]" placeholder="Unit price" step="0.01"
                        class="block w-1/4 px-3 py-2 mt-1 ml-2 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" oninput="calculateTotal()" required>

                    <button type="button"
                        class="px-3 py-2 ml-2 text-red-500 bg-transparent rounded-md hover:text-white"
                        onclick="removeInvoiceItem(this)">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                            <path
                                d="M24,4C12.972,4,4,12.972,4,24s8.972,20,20,20s20-8.972,20-20S35.028,4,24,4z M32.5,25.5h-17c-0.829,0-1.5-0.671-1.5-1.5s0.671-1.5,1.5-1.5h17c0.829,0,1.5,0.671,1.5,1.5S33.329,25.5,32.5,25.5z"
                                fill="currentColor" />
                        </svg>
                    </button>
                </div>
            `;
            itemsContainer.insertAdjacentHTML('beforeend', newItem);
        }

        // Function to remove an invoice item row
        function removeInvoiceItem(button) {
            const row = button.closest('.invoice-item-row');
            row.remove();
            calculateTotal(); // Recalculate the total after removing an item
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

        // Trigger the toggleAmountPaid function on page load
        window.onload = toggleAmountPaid;
    </script>
</x-app-layout>

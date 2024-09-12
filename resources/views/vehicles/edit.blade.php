<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Vehicle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Grid container for 2-column layout -->
                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-2">

                        <!-- Brand -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="brand"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Brand</label>
                            <input type="text" name="brand" id="brand"
                                value="{{ old('brand', $vehicle->brand) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Model -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="model"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Model</label>
                            <input type="text" name="model" id="model"
                                value="{{ old('model', $vehicle->model) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Year -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="year"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Year</label>
                            <input type="number" name="year" id="year"
                                value="{{ old('year', $vehicle->year) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Type -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Type</label>
                            <input type="text" name="type" id="type"
                                value="{{ old('type', $vehicle->type) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Color -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="color"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Color</label>
                            <input type="text" name="color" id="color"
                                value="{{ old('color', $vehicle->color) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- License Plate -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="license_plate"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">License Plate</label>
                            <input type="text" name="license_plate" id="license_plate"
                                value="{{ old('license_plate', $vehicle->license_plate) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Customer -->
                        <div class="col-span-2 mb-4 sm:col-span-2">
                            <label for="customer_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Customer</label>
                            <select name="customer_id" id="customer_id"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                                <option value="">Select a Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ $vehicle->customer_id == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Submit and Cancel Buttons using Jetstream components -->
                    <div class="mt-6">
                        <x-button class="mr-4">
                            {{ __('Update Vehicle') }}
                        </x-button>

                        <x-secondary-button type="button" onclick="window.location='{{ route('vehicles.index') }}'">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                </form>
                <div class="grid grid-cols-2 gap-6 sm:grid-cols-2">

                    <!-- Brand -->
                    <div class="col-span-2 mb-4 sm:col-span-1">
                        <!-- Add Vehicle History -->
                        <div class="mt-12">
                            <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200 mb-6">
                                {{ __('Add Vehicle History') }}
                            </h3>

                            <form action="{{ route('vehicle_histories.store', $vehicle->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                        History Description
                                    </label>
                                    <textarea name="description" id="description" rows="4"
                                        class="block w-full mt-1 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="service_date"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                        Service Date
                                    </label>
                                    <input type="date" name="service_date" id="service_date"
                                        value="{{ old('service_date') }}"
                                        class="block w-full mt-1 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        required>
                                    @error('service_date')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button for History -->
                                <x-button class="mt-4">
                                    {{ __('Add History') }}
                                </x-button>
                            </form>
                        </div>
                    </div>
                    <div class="col-span-2 mb-4 sm:col-span-1">
                        <!-- Display Existing Vehicle Histories -->
                        @if ($vehicle->histories->count())
                            <div class="mt-12">
                                <h3 class="text-lg font-semibold leading-tight text-gray-800 dark:text-gray-200 mb-6">
                                    {{ __('Vehicle History') }}
                                </h3>
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Description
                                            </th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Service Date
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @foreach ($vehicle->histories as $history)
                                            <tr>
                                                <td class="px-6 py-4">{{ $history->description }}</td>
                                                <td class="px-6 py-4">{{ $history->service_date }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

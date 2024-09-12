<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Add New Vehicle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <form action="{{ route('vehicles.store') }}" method="POST">
                    @csrf

                    <!-- Grid container for 2-column layout -->
                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-2">

                        <!-- Brand -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="brand"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Brand</label>
                            <input type="text" name="brand" id="brand"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Model -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="model"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Model</label>
                            <input type="text" name="model" id="model"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Year -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="year"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Year</label>
                            <input type="number" name="year" id="year"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Type -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Type</label>
                            <input type="text" name="type" id="type"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Color -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="color"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Color</label>
                            <input type="text" name="color" id="color"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- License Plate -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="license_plate"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">License Plate</label>
                            <input type="text" name="license_plate" id="license_plate"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                        </div>

                        <!-- Customer -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="customer_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Customer</label>
                            <select name="customer_id" id="customer_id"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                                <option value="">Select a Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <div class="mt-6">
                            <x-button class="mr-4">
                                {{ __('Add Vehicle') }}
                            </x-button>

                            <x-secondary-button type="button"
                                onclick="window.location='{{ route('vehicles.index') }}'">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit Customer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">

                <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-6 sm:grid-cols-2">
                        <!-- Name -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $customer->name) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $customer->email) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="phone_number"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number"
                                value="{{ old('phone_number', $customer->phone_number) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('phone_number')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Name -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="company_name"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Company Name</label>
                            <input type="text" name="company_name" id="company_name"
                                value="{{ old('company_name', $customer->company_name) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                required>
                            @error('company_name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ICE -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="ice"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">ICE</label>
                            <input type="text" name="ice" id="ice"
                                value="{{ old('ice', $customer->ice) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('ice')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Patente -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="patente"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Patente</label>
                            <input type="text" name="patente" id="patente"
                                value="{{ old('patente', $customer->patente) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('patente')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- ID Fiscale -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="id_fiscale"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">ID Fiscale</label>
                            <input type="text" name="id_fiscale" id="id_fiscale"
                                value="{{ old('id_fiscale', $customer->id_fiscale) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('id_fiscale')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-span-2 mb-4 sm:col-span-1">
                            <label for="address"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-200">Address</label>
                            <input type="text" name="address" id="address"
                                value="{{ old('address', $customer->address) }}"
                                class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm dark:border-gray-600 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            @error('address')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="mt-6">
                        <x-button class="mr-2">
                            {{ __('Update Customer') }}
                        </x-button>

                        <x-secondary-button type="button" onclick="window.location='{{ route('customers.index') }}'">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

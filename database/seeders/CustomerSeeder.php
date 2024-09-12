<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'ice' => 'ICE654321',
            'company_name' => 'Jane’s Workshop',
            'address' => '456 Elm St',
            'phone_number' => '987-654-3210',
            'patente' => 'PAT654321',
            'id_fiscale' => 'FISC654321',
        ]);
    }
}

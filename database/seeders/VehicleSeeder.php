<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vehicle::create([
            'brand' => 'Toyota',
            'model' => 'Corolla',
            'year' => '2020',
            'type' => 'Sedan',
            'color' => 'Blue',
            'license_plate' => 'ABC-123',
            'customer_id' => 1,
        ]);

        Vehicle::create([
            'brand' => 'Honda',
            'model' => 'Civic',
            'year' => '2019',
            'type' => 'Sedan',
            'color' => 'Black',
            'license_plate' => 'XYZ-789',
            'customer_id' => 1,
        ]);
    }
}

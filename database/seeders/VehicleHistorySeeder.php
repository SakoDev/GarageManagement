<?php

namespace Database\Seeders;

use App\Models\VehicleHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleHistory::create([
            'vehicle_id' => 1,
            'description' => 'Oil change',
            'service_date' => '2023-01-15',
        ]);

        VehicleHistory::create([
            'vehicle_id' => 2,
            'description' => 'Tire replacement',
            'service_date' => '2023-02-10',
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invoice::create([
            'invoice_id' => uniqid('INV', true),
            'vehicle_id' => 1,
            'customer_id' => 1,
            'invoice_date' => '2023-03-01',
            'status' => 'unpaid',
            'amount_paid' => 0,
            'balance_due' => 0,
            'vat_rate' => 20,
            'vat_amount' => 20,
            'total_amount' => 100,
        ]);
    }
}

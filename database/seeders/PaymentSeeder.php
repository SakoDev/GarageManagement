<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create([
            'invoice_id' => 1,
            'amount' => 50,
            'payment_date' => '2023-03-10',
            'payment_method' => 'Credit Card',
        ]);
    }
}

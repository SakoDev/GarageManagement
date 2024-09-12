<?php

namespace Database\Seeders;

use App\Models\InvoiceItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InvoiceItem::create([
            'invoice_id' => 1,
            'type' => 'item',
            'description' => 'Engine Oil',
            'quantity' => 2,
            'unit_amount' => 50,
        ]);
    }
}

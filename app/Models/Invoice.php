<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    // Define the number of digits you want in the invoice number
    const INVOICE_NUMBER_LENGTH = 5;

    protected $fillable = [
        'invoice_id',
        'customer_id',
        'vehicle_id',
        'invoice_date',
        'status',
        'amount_paid',
        'balance_due',
        'vat_rate',
        'vat_amount',
        'total_amount'
    ];

    /**
     * Generate a new invoice number.
     *
     * @return string
     */
    public static function generateInvoiceNumber()
    {
        // Get the last invoice number
        $lastInvoice = Invoice::orderBy('id', 'desc')->first();
        $lastNumber = $lastInvoice ? intval(substr($lastInvoice->invoice_id, 3)) : 0;

        // Increment the number
        $newNumber = $lastNumber + 1;

        // Return the formatted invoice number
        return 'INV' . str_pad($newNumber, self::INVOICE_NUMBER_LENGTH, '0', STR_PAD_LEFT);
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function updateBalance()
    {
        $this->balance_due = ($this->total_amount + $this->vat_amount) - $this->amount_paid;
        if ($this->amount_paid >= ($this->total_amount + $this->vat_amount)) {
            $this->status = 'paid';
        } elseif ($this->amount_paid > 0) {
            $this->status = 'partially_paid';
        } else {
            $this->status = 'unpaid';
        }
        $this->save();
    }

    public function calculateVAT()
    {
        if ($this->vat_rate > 0) {
            $this->vat_amount = ($this->total_amount * $this->vat_rate) / 100;
        } else {
            $this->vat_amount = 0;
        }
        $this->updateBalance();
        $this->save();
    }
}

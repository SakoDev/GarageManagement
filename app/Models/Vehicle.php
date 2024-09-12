<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'brand', 'model', 'year', 'type', 
        'color', 'license_plate', 'customer_id'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function histories()
    {
        return $this->hasMany(VehicleHistory::class);
    }
    // Vehicle has many invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id', 'description', 'service_date'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}

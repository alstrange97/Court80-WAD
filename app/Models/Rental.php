<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class Rental extends Model
{
    protected $table = 'rentals';
    protected $fillable = ['renter_name', 'renter_phone', 'start_time', 'duration_hours', 'total_amount', 'status'];

    public function items() {
        return $this->hasMany(RentalItem::class, 'rental_id');
    }
}
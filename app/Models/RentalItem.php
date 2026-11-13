<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Equipment; // <-- Pastikan ini ada
use App\Models\Rental;    // <-- Tambahkan ini

class RentalItem extends Model
{
    protected $table = 'rental_items';
    protected $fillable = ['rental_id', 'equipment_id', 'quantity', 'rate_per_hour', 'subtotal'];

    public function equipment() {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function rental() {
        return $this->belongsTo(Rental::class, 'rental_id');
    }
}
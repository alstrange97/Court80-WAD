<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $table = 'equipments';

    public $timestamps = false;

    protected $fillable = [
        'sport_id',
        'category_id',
        'name',
        'rental_rate',
        'unit_type',
        'stock',
        'image_url'
    ];

    public function sport()
    {
        return $this->belongsTo(Sport::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

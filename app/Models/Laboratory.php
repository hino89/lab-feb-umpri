<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'location', 'capacity', 'facilities', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function images()
    {
        return $this->hasMany(LaboratoryImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

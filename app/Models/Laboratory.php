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

    public function getIsCurrentlyInUseAttribute()
    {
        $now = now();
        return $this->bookings()
            ->where('status', 'approved')
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->exists();
    }
}

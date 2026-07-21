<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'laboratory_id', 'booker_name', 'booker_id', 'booker_type', 
        'start_time', 'end_time', 'purpose', 'status', 'admin_notes'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }
}

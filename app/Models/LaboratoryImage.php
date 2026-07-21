<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'laboratory_id', 'image_path', 'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function laboratory()
    {
        return $this->belongsTo(Laboratory::class);
    }
}

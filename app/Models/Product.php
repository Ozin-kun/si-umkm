<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id', 
        'name', 
        'description', 
        'price', 
        'image_path'
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}

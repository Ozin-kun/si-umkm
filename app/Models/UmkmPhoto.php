<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UmkmPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'umkm_id',
        'image_path',
        'sort_order',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'umkm_id',
        'admin_id',
        'status',
        'reason'
    ];

    // Relasi ke tabel UMKM
    public function umkm()
    {
        return $this->belongsTo(Umkm::class);
    }

    // Relasi ke tabel Users (sebagai Admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

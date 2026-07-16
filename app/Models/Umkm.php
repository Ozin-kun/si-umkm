<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'name', 'description', 
        'address', 'contact', 'latitude', 'longitude', 'status'
    ];

    protected $appends = ['google_maps_url'];

    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function products() { return $this->hasMany(Product::class); }
    public function placePhotos() { return $this->hasMany(UmkmPhoto::class)->orderBy('sort_order'); }

    public function getGoogleMapsUrlAttribute()
    {
        if ($this->latitude === null || $this->longitude === null) {
            return null;
        }

        return 'https://www.google.com/maps?q=' . $this->latitude . ',' . $this->longitude;
    }
}

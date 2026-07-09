<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Hanya ambil UMKM yang berstatus 'Disetujui' beserta relasi kategorinya
        // Diurutkan dari yang terbaru bergabung
        $umkms = Umkm::with('category')
                     ->where('status', 'Disetujui')
                     ->latest()
                     ->get();

        return view('welcome', compact('umkms'));
    }
}

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

    public function show($id)
    {
        // Cari UMKM berdasarkan ID, pastikan statusnya 'Disetujui'
        // Sekalian bawa data relasi 'category' dan 'products' agar tidak bolak-balik ke database
        $umkm = Umkm::with(['category', 'products'])->where('status', 'Disetujui')->findOrFail($id);

        return view('umkm-detail', compact('umkm'));
    }
}

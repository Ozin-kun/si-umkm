<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        // 1. Ambil semua kategori untuk ditampilkan di pilihan dropdown filter
        $categories = \App\Models\Category::all();

        // 2. Siapkan query dasar: Ambil UMKM yang disetujui
        $query = Umkm::with(['category', 'placePhotos'])->where('status', 'Disetujui');

        // 3. Jika pengunjung mengetikkan sesuatu di kotak pencarian
        if ($request->filled('cari')) {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        // 4. Jika pengunjung memilih filter kategori tertentu
        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        // 5. Eksekusi pencarian, urutkan dari yang terbaru, lalu paginate 12 item per halaman
        $umkms = $query->latest()->paginate(12)->withQueryString();

        if ($request->boolean('lazy')) {
            return response()->json([
                'html' => view('partials.public-umkm-cards', ['umkms' => $umkms->items()])->render(),
                'next_page_url' => $umkms->nextPageUrl(),
            ]);
        }

        return view('welcome', compact('umkms', 'categories'));
    }

    public function show(Request $request, $id)
    {
        $search = trim((string) $request->input('search', ''));

        // Cari UMKM berdasarkan ID, pastikan statusnya 'Disetujui'
        // Sekalian bawa data relasi 'category', 'placePhotos', dan produk yang sudah difilter
        $umkm = Umkm::with([
            'category',
            'placePhotos',
            'products' => function ($query) use ($search) {
                if ($search !== '') {
                    $query->where(function ($productQuery) use ($search) {
                        $productQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('description', 'like', '%' . $search . '%');
                    });
                }
            },
        ])->where('status', 'Disetujui')->findOrFail($id);

        return view('umkm-detail', compact('umkm', 'search'));
    }
}

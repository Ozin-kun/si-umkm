<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    // menampilkan halaman dashboard dan form profil
    public function index()
    {
        $user = Auth::user();
        $umkm = $user->umkm ? $user->umkm->load('placePhotos') : null; // Mengambil data umkm jika sudah ada
        $categories = Category::all(); // Mengambil semua pilihan kategori

        return view('umkm.dashboard', compact('umkm', 'categories'));
    }

    // Memproses penyimpanan atau pembaruan profil
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'address' => 'required|string',
            'contact' => 'required|string|max:50',
            'description' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'place_images' => 'nullable|array|max:10',
            'place_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        // Cari profil UMKM milik user yang login, jika tidak ada, buat baru
        $umkm = Umkm::updateOrCreate(
            ['user_id' => Auth::id()], // Kondisi pencarian
            [
                'category_id' => $request->category_id,
                'name' => $request->name,
                'address' => $request->address,
                'contact' => $request->contact,
                'description' => $request->description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                // Jika data diedit, statusnya kembali menjadi pending sesuai Business Rule (BR-04)
                'status' => 'Menunggu Verifikasi'
            ]
        );

        if ($request->hasFile('place_images')) {
            $nextOrder = (int) $umkm->placePhotos()->max('sort_order') + 1;

            foreach ($request->file('place_images') as $image) {
                $path = $image->store('umkm-places', 'public');

                $umkm->placePhotos()->create([
                    'image_path' => $path,
                    'sort_order' => $nextOrder,
                ]);

                $nextOrder++;
            }
        }

        return redirect()->route('umkm.dashboard')->with('success', 'Profil UMKM berhasil disimpan dan sedang menunggu verifikasi Admin.');
    }
}

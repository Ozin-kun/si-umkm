<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\VerificationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Menampilkan daftar UMKM di dashboard Admin
    public function index()
    {
        // Menghitung statistik pendaftaran
        $totalUmkm = Umkm::count();
        $pendingUmkm = Umkm::where('status', 'Menunggu Verifikasi')->count();
        $approvedUmkm = Umkm::where('status', 'Disetujui')->count();
        $rejectedUmkm = Umkm::whereIn('status', ['Ditolak', 'Direvisi', 'Nonaktif'])->count();

        // Mengambil semua data UMKM beserta relasi user dan kategorinya, diurutkan dari yang terbaru
        $umkms = Umkm::with(['user', 'category'])->orderBy('created_at', 'desc')->get();
        return view('admin.dashboard', compact('umkms','totalUmkm','pendingUmkm','approvedUmkm','rejectedUmkm'));
    }

    // Memproses perubahan status verifikasi
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Direvisi,Nonaktif',
            'reason' => 'nullable|string|max:255'
        ]);

        $umkm = Umkm::findOrFail($id);
        $umkm->update([
            'status' => $request->status
        ]);

        // Catat riwayat perubahan ke tabel verification_logs
        VerificationLog::create([
            'umkm_id' => $umkm->id,
            'admin_id' => Auth::id(),
            'status' => $request->status,
            'reason' => $request->reason
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Status UMKM "' . $umkm->name . '" berhasil diperbarui!');
    }
}

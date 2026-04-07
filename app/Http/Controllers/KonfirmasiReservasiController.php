<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use Illuminate\Http\Request;

class KonfirmasiReservasiController extends Controller
{
    /**
     * Menampilkan daftar reservasi untuk dikonfirmasi
     */
    public function index()
    {
        $konfirmasiReservasis = Reservasi::whereIn('status_reservasi_wisata', ['pesan', 'dibayar'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('konfirmasireservasi.index', [
            'title' => 'Konfirmasi Reservasi',
            'konfirmasiReservasis' => $konfirmasiReservasis
        ]);
    }

    /**
     * Update status reservasi
     */
    public function updateStatus(Request $request, $id)
    {
        // ✅ Validasi input
        $request->validate([
            'status' => 'required|in:pesan,dibayar,selesai'
        ]);

        // ✅ Ambil data reservasi
        $reservasi = Reservasi::findOrFail($id);

        // ✅ Update pakai cara aman
        $reservasi->update([
            'status_reservasi_wisata' => $request->input('status')
        ]);

        // ✅ Debug opsional (hapus kalau sudah normal)
        // dd($reservasi->fresh());

        // ✅ Handle AJAX (biar ga reload halaman)
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Status berhasil diupdate',
                'status' => $reservasi->status_reservasi_wisata,
                'id' => $reservasi->id,
            ]);
        }

        // ✅ Redirect normal
        return redirect()->route('konfirmasireservasi.index')
            ->with('success', 'Status reservasi berhasil diperbarui');
    }

    /**
     * Detail reservasi
     */
    public function show($id)
    {
        $reservasi = Reservasi::with(['pelanggan.user', 'paketWisata'])
            ->findOrFail($id);

        return view('konfirmasireservasi.show', compact('reservasi'));
    }
}
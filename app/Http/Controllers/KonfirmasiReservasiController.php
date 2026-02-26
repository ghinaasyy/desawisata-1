<?php

namespace App\Http\Controllers;

use App\Models\Reservasi; // Pastikan untuk mengimpor model Reservasi
use Illuminate\Http\Request;

class KonfirmasiReservasiController extends Controller
{
    public function index()
    {
        // Tampilkan reservasi yang masih menunggu konfirmasi (pesan)
        // dan juga yang sudah dibayar supaya tidak "hilang" setelah status diubah.
        $konfirmasiReservasis = Reservasi::whereIn('status_reservasi_wisata', ['pesan', 'dibayar'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('konfirmasireservasi.index', [
            'title' => 'Konfirmasi Reservasi',
            'konfirmasiReservasis' => $konfirmasiReservasis
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            // allowed statuses match migration enum: pesan, dibayar, selesai
            'status' => 'required|in:pesan,dibayar,selesai'
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->status_reservasi_wisata = $request->status;
        $reservasi->save();

        // If this is an AJAX request, return JSON so frontend can update without reload
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Status reservasi berhasil diperbarui',
                'status' => $reservasi->status_reservasi_wisata,
                'id' => $reservasi->id,
            ]);
        }

        return redirect()->route('konfirmasireservasi.index')
            ->with('success', 'Status reservasi berhasil diperbarui');
    }

    /**
     * Show a specific reservation for confirmation details
     */
    public function show($id)
    {
        $reservasi = Reservasi::with(['pelanggan.user','paketWisata'])->findOrFail($id);
        return view('konfirmasireservasi.show', compact('reservasi'));
    }
}
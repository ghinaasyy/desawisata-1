<?php

namespace App\Http\Controllers;

use App\Models\Reservasi; // Pastikan untuk mengimpor model Reservasi
use Illuminate\Http\Request;

class KonfirmasiReservasiController extends Controller
{
    public function index()
    {
        $konfirmasiReservasis = Reservasi::where('status_reservasi_wisata', 'pesan')->paginate(10);

        return view('konfirmasireservasi.index', [
            'title' => 'Konfirmasi Reservasi',
            'konfirmasiReservasis' => $konfirmasiReservasis
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:dibayar,selesa,canceled'
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->status_reservasi_wisata = $request->status;
        $reservasi->save();

        return redirect()->route('konfirmasireservasi.index')
            ->with('success', 'Status reservasi berhasil diperbarui');
    }
}
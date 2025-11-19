<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\PaketWisata;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservasiController extends Controller
{
    /**
     * Halaman form reservasi frontend
     */
    public function index()
    {
        // Sesuaikan dengan blade: fe/reservasi.blade.php pakai $paket
        $paket = PaketWisata::all();
        return view('fe.reservasi', compact('paket'));
    }

    /**
     * Form reservasi (tidak digunakan frontend biasa)
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $paket = PaketWisata::all();
        return view('reservasi.create', compact('paket'));
    }

    /**
     * Simpan data reservasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:paket_wisatas,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'jumlah_orang' => 'required|integer|min:1',
        ]);

        try {
            // Ambil paket
            $paket = PaketWisata::findOrFail($request->paket_id);

            $harga = $paket->harga_per_pack;
            $subtotal = $harga * $request->jumlah_orang;

            // Tanpa voucher dulu
            $nilai_diskon = 0;
            $diskon_flag = 0;

            $total_bayar = $subtotal - $nilai_diskon;

            // Buat reservasi
            $reservasi = Reservasi::create([
                'id_pelanggan' => Auth::user()->pelanggan->id,
                'id_paket' => $request->paket_id,
                'tgl_reservasi_wisata' => $request->tanggal,
                'harga' => $harga,
                'jumlah_peserta' => $request->jumlah_orang,
                'diskon' => $diskon_flag,
                'nilai_diskon' => $nilai_diskon,
                'total_bayar' => $total_bayar,
                'file_bukti_tf' => null, // frontend tidak wajib upload dulu
                'status_reservasi_wisata' => 'pesan'
            ]);

            return redirect()
                ->route('fe.reservasi-sukses', $reservasi->id)
                ->with('success', 'Reservasi berhasil dibuat!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal membuat reservasi: ' . $e->getMessage());
        }
    }

    /**
     * Halaman sukses setelah reservasi
     */
    public function success($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])
            ->findOrFail($id);

        if (
            Auth::user()->role !== 'admin' &&
            Auth::user()->pelanggan->id !== $reservasi->id_pelanggan
        ) {
            abort(403, 'Unauthorized');
        }

        return view('fe.reservasi-sukses', compact('reservasi'));
    }

    /**
     * Detail reservasi
     */
    public function show($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])
            ->findOrFail($id);

        if (
            Auth::user()->role !== 'admin' &&
            Auth::user()->pelanggan->id !== $reservasi->id_pelanggan
        ) {
            abort(403, 'Unauthorized');
        }

        return view('fe.reservasi-show', compact('reservasi'));
    }

    /**
     * Riwayat reservasi user
     */
    public function riwayat()
    {
        $reservasis = Reservasi::with('paketWisata')
            ->where('id_pelanggan', Auth::user()->pelanggan->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('fe.riwayatreservasi', compact('reservasis'));
    }

    /**
     * Update status reservasi (admin)
     */
    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'status_reservasi_wisata' => 'required|in:pesan,dibayar,selesai',
        ]);

        Reservasi::findOrFail($id)->update([
            'status_reservasi_wisata' => $request->status_reservasi_wisata
        ]);

        return back()->with('success', 'Status berhasil diupdate');
    }

    /**
     * Halaman invoice (preview)
     */
    public function invoice($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])->findOrFail($id);
        return view('reservasi.invoice', compact('reservasi'));
    }

    /**
     * Download invoice PDF
     */
    public function downloadInvoice($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])->findOrFail($id);

        $pdf = Pdf::loadView('reservasi.invoice', compact('reservasi'));
        return $pdf->download('invoice-' . $reservasi->id . '.pdf');
    }

    /**
     * Download invoice tanpa auth
     */
    public function downloadInvoicePublic($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])->findOrFail($id);
        $pdf = Pdf::loadView('reservasi.invoice', compact('reservasi'));
        return $pdf->stream('invoice-' . $reservasi->id . '.pdf');
    }
}

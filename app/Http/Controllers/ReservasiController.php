<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\PaketWisata;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    public function create()
    {
        $paket = PaketWisata::all();
        return view('fe.reservasi', compact('paket'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_hp' => 'required|string|max:30',
            'alamat' => 'required|string|max:1000',
            'id_paket' => 'required|exists:paket_wisatas,id',
            'tgl_reservasi_wisata' => 'required|date',
            'jumlah_peserta' => 'required|integer|min:1',
            'file_bukti_tf' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Cari atau buat pelanggan. Jika user login dan punya pelanggan, pakai itu.
        $pelanggan = null;
        if (Auth::check()) {
            $pelanggan = Auth::user()->pelanggan;
            if (!$pelanggan) {
                $pelanggan = Pelanggan::create([
                    'nama_lengkap' => $data['nama_lengkap'],
                    'no_hp' => $data['no_hp'],
                    'alamat' => $data['alamat'],
                    'id_user' => Auth::id(),
                ]);
            } else {
                // update kontak pelanggan jika perlu
                $pelanggan->update([
                    'nama_lengkap' => $data['nama_lengkap'],
                    'no_hp' => $data['no_hp'],
                    'alamat' => $data['alamat'],
                ]);
            }
        } else {
            // buat pelanggan sementara (tanpa user)
            $pelanggan = Pelanggan::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'no_hp' => $data['no_hp'],
                'alamat' => $data['alamat'],
            ]);
        }

        $paket = PaketWisata::findOrFail($data['id_paket']);
        $hargaPerOrang = $paket->harga_per_pack;
        $jumlah = (int) $data['jumlah_peserta'];
        $hargaSnapshot = $hargaPerOrang;
        $total = $hargaPerOrang * $jumlah;

        // handle file upload
        $pathBukti = null;
        if ($request->hasFile('file_bukti_tf')) {
            $pathBukti = $request->file('file_bukti_tf')->store('bukti_tf', 'public');
        }

        $reservasi = Reservasi::create([
            'id_pelanggan' => $pelanggan->id,
            'id_paket' => $paket->id,
            'tgl_reservasi_wisata' => $data['tgl_reservasi_wisata'],
            'harga' => $hargaSnapshot,
            'jumlah_peserta' => $jumlah,
            'diskon' => 0,
            'nilai_diskon' => 0,
            'total_bayar' => $total,
            'file_bukti_tf' => $pathBukti,
            'status_reservasi_wisata' => 'pesan',
        ]);

        return redirect()->route('reservasi.show', $reservasi->id)->with('success', 'Reservasi berhasil dibuat.');
    }

    public function show($id)
    {
        $reservasi = Reservasi::with(['pelanggan','paketWisata'])->findOrFail($id);
        return view('fe.reservasi-show', compact('reservasi'));
    }

    /**
     * Public/Frontend index - show reservation form (alias)
     */
    public function index()
    {
        $paket = PaketWisata::all();
        return view('fe.reservasi', compact('paket'));
    }

    /**
     * Show history for authenticated user
     */
    public function riwayat()
    {
        if (!Auth::check() || !Auth::user()->pelanggan) {
            return redirect()->route('login');
        }
        $reservasis = Reservasi::with('paketWisata')
            ->where('id_pelanggan', Auth::user()->pelanggan->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('fe.riwayatreservasi', compact('reservasis'));
    }

    /**
     * Success page (authenticated)
     */
    public function success($id)
    {
        $reservasi = Reservasi::with(['paketWisata','pelanggan'])->findOrFail($id);
        return view('fe.reservasi-sukses', compact('reservasi'));
    }

    // Public alias for success (named 'sukses' in routes)
    public function sukses($id)
    {
        return $this->success($id);
    }

    // Invoice view (authenticated)
    public function invoice($id)
    {
        $reservasi = Reservasi::with(['paketWisata','pelanggan'])->findOrFail($id);
        return view('reservasi.invoice', compact('reservasi'));
    }

    // Download invoice (authenticated) - try PDF if available, else render view
    public function downloadInvoice($id)
    {
        $reservasi = Reservasi::with(['paketWisata','pelanggan'])->findOrFail($id);
        // If DomPDF is available, use it; otherwise show view
        if (class_exists('\\Barryvdh\\DomPDF\\Facade\\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reservasi.invoice', compact('reservasi'));
            return $pdf->download('invoice-' . $reservasi->id . '.pdf');
        }
        return view('reservasi.invoice', compact('reservasi'));
    }

    // Public invoice download/stream (no auth)
    public function downloadInvoicePublic($id)
    {
        $reservasi = Reservasi::with(['paketWisata','pelanggan'])->findOrFail($id);
        if (class_exists('\\Barryvdh\\DomPDF\\Facade\\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reservasi.invoice', compact('reservasi'));
            return $pdf->stream('invoice-' . $reservasi->id . '.pdf');
        }
        return view('reservasi.invoice', compact('reservasi'));
    }

    // Show specific reservation from public riwayat route
    public function showRiwayat($id)
    {
        $reservasi = Reservasi::with(['paketWisata','pelanggan'])->findOrFail($id);
        return view('fe.riwayat-detail', compact('reservasi'));
    }
}
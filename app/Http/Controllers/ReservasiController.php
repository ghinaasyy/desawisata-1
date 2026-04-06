<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\PaketWisata;
use App\Models\Pelanggan;
use App\Models\Diskon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ReservasiController extends Controller
{
    public function create()
    {
        $paket = PaketWisata::all();
        return view('fe.reservasi', compact('paket'));
    }

    public function index()
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
            'diskon' => 'nullable|string',
            'nilai_diskon' => 'nullable|numeric'
        ]);

        /**
         * =========================
         * HANDLE PELANGGAN
         * =========================
         */
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
                $pelanggan->update([
                    'nama_lengkap' => $data['nama_lengkap'],
                    'no_hp' => $data['no_hp'],
                    'alamat' => $data['alamat'],
                ]);
            }
        } else {
            $pelanggan = Pelanggan::create([
                'nama_lengkap' => $data['nama_lengkap'],
                'no_hp' => $data['no_hp'],
                'alamat' => $data['alamat'],
            ]);
        }

        /**
         * =========================
         * AMBIL DATA PAKET
         * =========================
         */
        $paket = PaketWisata::findOrFail($data['id_paket']);
        $hargaPerOrang = $paket->harga_per_pack;
        $jumlah = (int) $data['jumlah_peserta'];

        $hargaSnapshot = $hargaPerOrang;
        $totalKotor = $hargaPerOrang * $jumlah;

        /**
         * =========================
         * HANDLE DISKON
         * =========================
         */
        $diskonKode = $request->diskon;
        $nilaiDiskon = is_numeric($request->nilai_diskon) ? (float)$request->nilai_diskon : 0;

        if ($diskonKode) {
            $diskon = Diskon::where('kode', $diskonKode)->first();

            if ($diskon) {

                // cek kuota
                if ($diskon->digunakan >= $diskon->kuota) {
                    $nilaiDiskon = 0;
                    $diskonKode = null;
                }

                // cek minimal transaksi
                if ($totalKotor < $diskon->minimal_transaksi) {
                    $nilaiDiskon = 0;
                    $diskonKode = null;
                }

                // hitung ulang (biar aman)
                if ($diskon->jenis_diskon == 'persentase') {
                    $nilaiDiskon = ($diskon->nilai_diskon / 100) * $totalKotor;
                } else {
                    $nilaiDiskon = $diskon->nilai_diskon;
                }

                // batas maksimal diskon
                if ($diskon->maksimal_diskon && $nilaiDiskon > $diskon->maksimal_diskon) {
                    $nilaiDiskon = $diskon->maksimal_diskon;
                }
            } else {
                $nilaiDiskon = 0;
                $diskonKode = null;
            }
        }

        /**
         * =========================
         * TOTAL AKHIR
         * =========================
         */
        $total = max(0, $totalKotor - $nilaiDiskon);

        /**
         * =========================
         * UPLOAD FILE
         * =========================
         */
        $pathBukti = null;
        if ($request->hasFile('file_bukti_tf')) {
            $pathBukti = $request->file('file_bukti_tf')->store('bukti_tf', 'public');
        }

        /**
         * =========================
         * SIMPAN RESERVASI
         * =========================
         */
        $reservasi = Reservasi::create([
            'id_pelanggan' => $pelanggan->id,
            'id_paket' => $paket->id,
            'tgl_reservasi_wisata' => $data['tgl_reservasi_wisata'],
            'harga' => (float) $hargaSnapshot,
            'jumlah_peserta' => $jumlah,
            'diskon' => $diskonKode,
            'nilai_diskon' => (float) $nilaiDiskon,
            'total_bayar' => (float) $total,
            'file_bukti_tf' => $pathBukti,
            'status_reservasi_wisata' => 'pesan',
        ]);

        /**
         * =========================
         * UPDATE KUOTA DISKON
         * =========================
         */
        if ($diskonKode) {
            $diskon = Diskon::where('kode', $diskonKode)->first();
            if ($diskon) {
                $diskon->increment('digunakan');
            }
        }

        return redirect()
            ->route('reservasi.show', $reservasi->id)
            ->with('success', 'Reservasi berhasil dibuat.');
    }

    public function show($id)
    {
        $reservasi = Reservasi::with(['pelanggan', 'paketWisata'])->findOrFail($id);
        return view('fe.reservasi-show', compact('reservasi'));
    }

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

    public function success($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])->findOrFail($id);
        return view('fe.reservasi-sukses', compact('reservasi'));
    }

    public function sukses($id)
    {
        return $this->success($id);
    }

    public function invoice($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])->findOrFail($id);
        return view('fe.invoice', compact('reservasi'));
    }

    public function downloadInvoice($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])->findOrFail($id);

        if (class_exists('\\Barryvdh\\DomPDF\\Facade\\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('fe.invoice-pdf', compact('reservasi'))
                ->setPaper('a4', 'portrait');
            return $pdf->download('invoice-' . $reservasi->id . '.pdf');
        }

        if (class_exists('\\Dompdf\\Dompdf')) {
            $html = view('fe.invoice-pdf', compact('reservasi'))->render();
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);

            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice-' . $reservasi->id . '.pdf"'
            ]);
        }

        return view('fe.invoice', compact('reservasi'));
    }

    public function downloadInvoicePublic($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])->findOrFail($id);

        if (class_exists('\\Barryvdh\\DomPDF\\Facade\\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('fe.invoice-pdf', compact('reservasi'))
                ->setPaper('a4', 'portrait');
            return $pdf->stream('invoice-' . $reservasi->id . '.pdf');
        }

        if (class_exists('\\Dompdf\\Dompdf')) {
            $html = view('fe.invoice-pdf', compact('reservasi'))->render();
            $options = new \Dompdf\Options();
            $options->set('isRemoteEnabled', true);

            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            return response($dompdf->stream(), 200, [
                'Content-Type' => 'application/pdf'
            ]);
        }

        return view('fe.invoice', compact('reservasi'));
    }

    public function showRiwayat($id)
    {
        $reservasi = Reservasi::with(['paketWisata', 'pelanggan'])->findOrFail($id);
        return view('fe.riwayat-detail', compact('reservasi'));
    }
}

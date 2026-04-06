<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vouchers = Diskon::orderBy('created_at', 'desc')->get();
        return view('voucher.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:diskons,kode|max:50',
            'nama_promo' => 'required|max:255',
            'detail_promo' => 'nullable|string',
            'nilai_diskon' => 'required|numeric|min:0',
            'jenis_diskon' => 'required|in:persentase,nominal',
            'minimal_transaksi' => 'required|integer|min:0',
            'maksimal_diskon' => 'nullable|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'kuota' => 'nullable|integer|min:1',
        ]);

        $voucher = Diskon::create([
            'kode' => $validated['kode'],
            'nama_promo' => $validated['nama_promo'],
            'detail_promo' => $validated['detail_promo'] ?? null,
            'nilai_diskon' => $validated['nilai_diskon'],
            'jenis_diskon' => $validated['jenis_diskon'],
            'minimal_transaksi' => $validated['minimal_transaksi'],
            'maksimal_diskon' => $validated['maksimal_diskon'] ?? null,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_berakhir' => $validated['tanggal_berakhir'],
            'kuota' => $validated['kuota'] ?? null,
            'digunakan' => 0,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil ditambahkan!',
                'redirect' => route('voucher.index')
            ]);
        }

        return redirect()->route('voucher.index')->with('success', 'Voucher berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Diskon $voucher)
    {
        $validated = $request->validate([
            'kode' => 'required|max:50|unique:diskons,kode,' . $voucher->id,
            'nama_promo' => 'required|max:255',
            'detail_promo' => 'nullable|string',
            'nilai_diskon' => 'required|numeric|min:0',
            'jenis_diskon' => 'required|in:persentase,nominal',
            'minimal_transaksi' => 'required|integer|min:0',
            'maksimal_diskon' => 'nullable|integer|min:0',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            'kuota' => 'nullable|integer|min:1',
        ]);

        $voucher->update([
            'kode' => $validated['kode'],
            'nama_promo' => $validated['nama_promo'],
            'detail_promo' => $validated['detail_promo'] ?? null,
            'nilai_diskon' => $validated['nilai_diskon'],
            'jenis_diskon' => $validated['jenis_diskon'],
            'minimal_transaksi' => $validated['minimal_transaksi'],
            'maksimal_diskon' => $validated['maksimal_diskon'] ?? null,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_berakhir' => $validated['tanggal_berakhir'],
            'kuota' => $validated['kuota'] ?? null,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Voucher berhasil diperbarui!',
                'redirect' => route('voucher.index')
            ]);
        }

        return redirect()->route('voucher.index')->with('success', 'Voucher berhasil diperbarui!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Diskon $voucher)
    {
        return view('voucher.edit', compact('voucher'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Diskon $voucher)
    {
        // Cek jika voucher sudah digunakan
        if ($voucher->digunakan > 0) {
            return redirect()->route('voucher.index')
                ->with('error', 'Voucher tidak dapat dihapus karena sudah digunakan!');
        }

        $voucher->delete();
        return redirect()->route('voucher.index')->with('success', 'Voucher berhasil dihapus!');
    }

    /**
     * Fungsi untuk claim voucher oleh pelanggan
     */
    public function claim(Request $request)
    {
        $request->validate([
            'kode_voucher' => 'required|string',
            'total_transaksi' => 'required|numeric|min:0'
        ]);

        $voucher = Diskon::where('kode', $request->kode_voucher)->first();

        if (!$voucher) {
            return back()->with('error', 'Kode voucher tidak valid');
        }

        // Validasi voucher
        $now = Carbon::now();
        if ($now->lt($voucher->tanggal_mulai) || $now->gt($voucher->tanggal_berakhir)) {
            return back()->with('error', 'Voucher tidak berlaku pada periode ini');
        }

        if ($voucher->kuota && $voucher->digunakan >= $voucher->kuota) {
            return back()->with('error', 'Kuota voucher sudah habis');
        }

        if ($request->total_transaksi < $voucher->minimal_transaksi) {
            return back()->with('error', 'Minimal transaksi Rp ' . number_format($voucher->minimal_transaksi, 0, ',', '.'));
        }

        // Hitung diskon
        $diskon = 0;
        if ($voucher->jenis_diskon == 'persentase') {
            $diskon = $request->total_transaksi * ($voucher->nilai_diskon / 100);
            if ($voucher->maksimal_diskon && $diskon > $voucher->maksimal_diskon) {
                $diskon = $voucher->maksimal_diskon;
            }
        } else {
            $diskon = $voucher->nilai_diskon;
        }

        // Simpan ke session
        session([
            'voucher' => [
                'id' => $voucher->id,
                'kode' => $voucher->kode,
                'diskon' => $diskon
            ]
        ]);

        return back()->with('success', 'Voucher berhasil digunakan. Diskon: Rp ' . number_format($diskon, 0, ',', '.'));
    }
}

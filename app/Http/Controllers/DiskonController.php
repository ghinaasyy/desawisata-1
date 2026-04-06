<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diskon;
use Carbon\Carbon;

class DiskonController extends Controller
{
    public function cek(Request $request)
    {
        $kode = $request->kode;
        $total = $request->total;

        $diskon = Diskon::where('kode', $kode)->first();

        if (!$diskon) {
            return response()->json(['status' => false, 'message' => 'Kode tidak ditemukan']);
        }

        $today = Carbon::today();

        if ($today < $diskon->tanggal_mulai || $today > $diskon->tanggal_berakhir) {
            return response()->json(['status' => false, 'message' => 'Diskon tidak berlaku']);
        }

        if ($total < $diskon->minimal_transaksi) {
            return response()->json(['status' => false, 'message' => 'Minimal transaksi belum terpenuhi']);
        }

        if ($diskon->digunakan >= $diskon->kuota) {
            return response()->json(['status' => false, 'message' => 'Kuota habis']);
        }

        // hitung diskon
        if ($diskon->jenis_diskon == 'persentase') {
            $nilai = ($diskon->nilai_diskon / 100) * $total;
        } else {
            $nilai = $diskon->nilai_diskon;
        }

        // maksimal diskon
        if ($diskon->maksimal_diskon && $nilai > $diskon->maksimal_diskon) {
            $nilai = $diskon->maksimal_diskon;
        }

        return response()->json([
            'status' => true,
            'nilai_diskon' => $nilai,
            'kode' => $diskon->kode
        ]);
    }
}
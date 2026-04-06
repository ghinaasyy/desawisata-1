<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Pelanggan;
use App\Models\PaketWisata;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OwnerController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter ?? 'bulan';

        $query = Reservasi::query();

        // FILTER WAKTU
        if ($filter == 'hari') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter == 'minggu') {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($filter == 'bulan') {
            $query->whereMonth('created_at', Carbon::now()->month);
        } elseif ($filter == 'tahun') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        $totalReservasi = $query->count();
        $totalPendapatan = $query->sum('total_bayar');

        return view('owner.index', [
            'title' => 'Owner',

            'totalReservasi' => $totalReservasi,
            'totalPendapatan' => $totalPendapatan,
            'totalPelanggan' => Pelanggan::count(),
            'totalUser' => User::count(),
            'totalPaket' => PaketWisata::count(),

            'reservasiTerbaru' => Reservasi::latest()->take(5)->get(),
            'users' => User::latest()->take(5)->get(),
            'pelangganList' => Pelanggan::latest()->take(5)->get(),

            'filter' => $filter
        ]);
    }


    public function exportPdf(Request $request)
    {
        $filter = $request->filter ?? 'bulan';

        $query = Reservasi::query();

        if ($filter == 'hari') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter == 'minggu') {
            $query->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]);
        } elseif ($filter == 'bulan') {
            $query->whereMonth('created_at', Carbon::now()->month);
        } elseif ($filter == 'tahun') {
            $query->whereYear('created_at', Carbon::now()->year);
        }

        $reservasi = $query->get();
        $totalPendapatan = $query->sum('total_bayar');

        $pdf = Pdf::loadView('owner.laporan-pdf', compact('reservasi', 'totalPendapatan', 'filter'));

        return $pdf->download('laporan-' . $filter . '.pdf');
    }


    public function users()
    {
        return view('owner.users', [
            'users' => \App\Models\User::latest()->get(),
            'pelanggan' => \App\Models\Pelanggan::latest()->get()
        ]);
    }

    public function keuangan(Request $request)
    {
        $filter = $request->filter ?? 'bulan';

        $query = \App\Models\Reservasi::query();

        if ($filter == 'hari') {
            $query->whereDate('created_at', now());
        } elseif ($filter == 'minggu') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter == 'bulan') {
            $query->whereMonth('created_at', now()->month);
        } elseif ($filter == 'tahun') {
            $query->whereYear('created_at', now()->year);
        }

        return view('owner.keuangan', [
            'reservasi' => $query->latest()->get(),
            'totalPendapatan' => $query->sum('total_bayar'),
            'filter' => $filter
        ]);
    }
}

@extends('fe.master')

@section('content')
<div class="container py-5 mt-5" style="padding-top:90px;">
    <style>
        /* Minimal modern invoice table */
        .invoice-card { background: #fff; border-radius: 8px; }
        .invoice-table td { padding: .65rem .75rem; vertical-align: middle; }
        .invoice-table tr + tr td { border-top: 1px solid #e9ecef; }
        .invoice-table .label { color: #6c757d; }
        .invoice-table .value { text-align: right; font-weight:600; color:#111; }
        @media (max-width:576px) {
            .invoice-table .label { font-size: 13px; }
            .invoice-table .value { font-size: 14px; }
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h3>Invoice Reservasi Desa Wisata</h3>
                <p><strong>Pelanggan:</strong> {{ optional($reservasi->pelanggan)->nama_lengkap ?? '-' }}</p>
                <p><strong>Paket:</strong> {{ optional($reservasi->paketWisata)->nama_paket ?? '-' }}</p>

                <div class="table-responsive mt-3">
                    <table class="table table-sm mb-0 invoice-table">
                        <tbody>
                            <tr>
                                <td class="label">Harga per Paket</td>
                                <td class="value">Rp {{ number_format($reservasi->harga,0,',','.') }}</td>
                            </tr>
                            <tr>
                                <td class="label">Jumlah Peserta</td>
                                <td class="value">{{ $reservasi->jumlah_peserta }}</td>
                            </tr>
                            <tr>
                                <td class="label">Diskon</td>
                                <td class="value">{{ $reservasi->diskon }} %</td>
                            </tr>
                            <tr>
                                <td class="label fw-bold">Total Bayar</td>
                                <td class="value">Rp {{ number_format($reservasi->total_bayar,0,',','.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ url('/reservasi/riwayat') }}" class="btn btn-outline-secondary">Tutup</a>
                    <a href="{{ url('/reservasi/download-invoice/' . $reservasi->id) }}" class="btn btn-primary">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

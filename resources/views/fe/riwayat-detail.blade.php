@extends('fe.master')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h2>Detail Riwayat Reservasi #{{ $reservasi->id }}</h2>

            <p><strong>Paket:</strong> {{ optional($reservasi->paketWisata)->nama_paket ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $reservasi->tgl_reservasi_wisata }}</p>
            <p><strong>Jumlah:</strong> {{ $reservasi->jumlah_peserta }}</p>
            <p><strong>Total:</strong> {{ number_format($reservasi->total_bayar,0,',','.') }}</p>

            <a href="{{ url('/reservasi/invoice/' . $reservasi->id) }}" class="btn btn-primary">Lihat Invoice</a>
            <a href="{{ url('/riwayat') }}" class="btn btn-link">Kembali ke Riwayat</a>
        </div>
    </div>
</div>

@endsection

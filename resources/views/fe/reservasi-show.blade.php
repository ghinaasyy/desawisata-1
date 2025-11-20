
<!-- page yang nunjukin hasil per reservasi -->

@extends('fe.master')

@section('content')
<div class="container py-5 mt-5" style="padding-top:90px;">
    @php
        $pel = optional($reservasi->pelanggan);
        $pak = optional($reservasi->paketWisata);
        $status = $reservasi->status_reservasi_wisata ?? 'pending';
        $badgeClass = match($status) {
            'confirmed' => 'bg-success text-white',
            'paid' => 'bg-success text-white',
            'cancel' => 'bg-danger text-white',
            'pesan' => 'bg-warning text-dark',
            default => 'bg-secondary text-white'
        };
    @endphp

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                @if($pak && $pak->foto1)
                    <img src="{{ asset('storage/' . $pak->foto1) }}" class="card-img-top" style="height:260px; object-fit:cover;">
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="mb-1">Reservasi #{{ $reservasi->id }}</h3>
                            <div class="text-muted">Paket: <strong>{{ $pak->nama_paket ?? '-' }}</strong></div>
                        </div>
                        <span class="badge rounded-pill {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="small text-muted">Nama Pemesan</div>
                            <div class="fw-bold">{{ $pel->nama_lengkap ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <div class="small text-muted">Nomor HP</div>
                            <div class="fw-bold">{{ $pel->no_hp ?? '-' }}</div>
                        </div>
                        <div class="col-12">
                            <div class="small text-muted">Alamat</div>
                            <div>{{ $pel->alamat ?? '-' }}</div>
                        </div>
                    </div>

                    <hr>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="small text-muted">Tanggal Reservasi</div>
                            <div class="fw-bold">{{ \Illuminate\Support\Carbon::parse($reservasi->tgl_reservasi_wisata)->translatedFormat('d M Y') }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="small text-muted">Jumlah Peserta</div>
                            <div class="fw-bold">{{ $reservasi->jumlah_peserta }}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="small text-muted">Harga per Paket</div>
                            <div class="fw-bold">Rp {{ number_format($reservasi->harga,0,',','.') }}</div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
                        @php $invoiceUrl = \Illuminate\Support\Facades\Route::has('reservasi.invoice') ? route('reservasi.invoice', $reservasi->id) : route('fe.invoice', $reservasi->id); @endphp
                        <a href="{{ $invoiceUrl }}" class="btn btn-primary">Lihat / Unduh Invoice</a>
                        @if($reservasi->file_bukti_tf)
                            <a href="{{ asset('storage/' . $reservasi->file_bukti_tf) }}" target="_blank" class="btn btn-outline-info">Lihat Bukti TF</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Ringkasan</h5>
                    <div class="d-flex justify-content-between mb-2"><div class="text-muted">Harga</div><div>Rp {{ number_format($reservasi->harga,0,',','.') }}</div></div>
                    <div class="d-flex justify-content-between mb-2"><div class="text-muted">Jumlah</div><div>{{ $reservasi->jumlah_peserta }}</div></div>
                    <div class="d-flex justify-content-between mb-2"><div class="text-muted">Diskon</div><div>{{ $reservasi->diskon }} %</div></div>
                    <hr>
                    <div class="d-flex justify-content-between"><div class="fw-bold">Total Bayar</div><div class="fw-bold">Rp {{ number_format($reservasi->total_bayar,0,',','.') }}</div></div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

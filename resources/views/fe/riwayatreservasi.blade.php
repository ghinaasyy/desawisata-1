<!-- halaman reservasiku -->

@extends('fe.master')

@section('content')
<div class="container py-5 mt-5" style="padding-top:90px;">
    <h2 class="mb-4 fw-bold">Riwayat Reservasi</h2>

    @if(isset($reservasis) && $reservasis->count())
        <div class="row g-4">
            @foreach($reservasis as $r)
                @php
                    $pak = optional($r->paketWisata);
                    $status = $r->status_reservasi_wisata ?? 'pending';
                    $badgeClass = match($status) {
                        'confirmed' => 'bg-success text-white',
                        'paid' => 'bg-success text-white',
                        'cancel' => 'bg-danger text-white',
                        'pesan' => 'bg-warning text-dark',
                        default => 'bg-secondary text-white'
                    };
                @endphp
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        @if($pak && optional($pak)->foto1)
                            <img src="{{ asset('storage/' . $pak->foto1) }}" class="card-img-top" alt="{{ $pak->nama_paket }}" style="height:160px; object-fit:cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h5 class="card-title mb-1">#{{ $r->id }} - {{ $pak->nama_paket ?? '-' }}</h5>
                                    <div class="text-muted small">{{ \Illuminate\Support\Carbon::parse($r->tgl_reservasi_wisata)->translatedFormat('d M Y') }} · {{ $r->jumlah_peserta }} orang</div>
                                </div>
                                <span class="badge rounded-pill {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                            </div>

                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small">Total</div>
                                    <div class="fw-bold">Rp {{ number_format($r->total_bayar,0,',','.') }}</div>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ \Illuminate\Support\Facades\Route::has('reservasi.show') ? route('reservasi.show', $r->id) : url('/reservasi/' . $r->id) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                                    @php
                                        $invoiceUrl = \Illuminate\Support\Facades\Route::has('fe.invoice') ? route('reservasi.invoice', $r->id) : route('fe.invoice', $r->id);
                                    @endphp
                                    <a href="{{ $invoiceUrl }}" class="btn btn-sm btn-primary">Invoice</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Belum ada riwayat reservasi.</div>
    @endif

    <div class="mt-4">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
    </div>
</div>

@endsection

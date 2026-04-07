@extends('fe.master')

@section('title', 'Detail Reservasi')

@section('content')

<div class="container py-10 mt-10" style="padding-top:130px;">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-info-circle me-2"></i>Detail Reservasi</h2>
    <a href="{{ route('reservasi.riwayat') }}" class="btn btn-outline-primary">
      <i class="bi bi-arrow-left me-1"></i>Kembali
    </a>
  </div>

  @if(session('success'))
  <div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  @endif

  <div class="card shadow-sm">
    <div class="card-body p-4">

      <!-- HEADER -->
      <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
          <h4 class="mb-1 fw-bold">Reservasi #{{ $reservasi->id }}</h4>
          <small class="text-muted">
            {{ $reservasi->created_at->format('d F Y H:i') }}
          </small>
        </div>

        @switch($reservasi->status_reservasi_wisata)
        @case('pesan')
        <span class="badge bg-warning">Menunggu</span>
        @break
        @case('dibayar')
        <span class="badge bg-primary">Dibayar</span>
        @break
        @case('selesai')
        <span class="badge bg-success">Selesai</span>
        @break
        @endSwitch
      </div>

      <hr>

      <!-- INFORMASI PEMESAN -->
      <div class="mb-4">
        <h6 class="fw-bold mb-3">Informasi Pemesan</h6>

        <div class="row g-3">
          <div class="col-md-4">
            <small class="text-muted">Nama</small>
            <div class="fw-semibold">{{ $reservasi->pelanggan->nama_lengkap }}</div>
          </div>
          <div class="col-md-4">
            <small class="text-muted">No HP</small>
            <div class="fw-semibold">{{ $reservasi->pelanggan->no_hp }}</div>
          </div>
          <div class="col-md-4">
            <small class="text-muted">Email</small>
            <div class="fw-semibold">{{ $reservasi->pelanggan->user->email }}</div>
          </div>
        </div>
      </div>

      <!-- PAKET -->
      <div class="mb-4">
        <h6 class="fw-bold mb-3">Paket Wisata</h6>

        <div class="row g-3">
          <div class="col-md-6">
            <small class="text-muted">Nama Paket</small>
            <div class="fw-semibold">{{ $reservasi->paketWisata->nama_paket }}</div>
          </div>
          <div class="col-md-6 text-md-end">
            <small class="text-muted">Harga</small>
            <div class="fw-bold text-primary">
              Rp {{ number_format($reservasi->harga,0,',','.') }}
            </div>
          </div>
          <div class="col-12">
            <small class="text-muted">Deskripsi</small>
            <div>{{ $reservasi->paketWisata->deskripsi }}</div>
          </div>
        </div>
      </div>

      <!-- DETAIL -->
      <div class="mb-4">
        <h6 class="fw-bold mb-3">Detail Reservasi</h6>

        <div class="row g-3">
          <div class="col-md-4">
            <small class="text-muted">Tanggal</small>
            <div class="fw-semibold">
              {{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_wisata)->format('d F Y') }}
            </div>
          </div>
          <div class="col-md-4">
            <small class="text-muted">Peserta</small>
            <div class="fw-semibold">{{ $reservasi->jumlah_peserta }} orang</div>
          </div>
          <div class="col-md-4">
            <small class="text-muted">Status</small>
            <div class="fw-semibold">
              {{ ucwords(str_replace('_', ' ', $reservasi->status_reservasi_wisata)) }}
            </div>
          </div>
        </div>
      </div>

      <!-- PEMBAYARAN -->
      <div class="mb-4">
        <h6 class="fw-bold mb-3">Pembayaran</h6>

        <div class="bg-light rounded p-3">

          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Subtotal</span>
            <span>Rp {{ number_format($reservasi->harga * $reservasi->jumlah_peserta,0,',','.') }}</span>
          </div>

          @if($reservasi->nilai_diskon > 0)
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Diskon</span>
            <span class="text-danger">
              - Rp {{ number_format($reservasi->nilai_diskon,0,',','.') }}
            </span>
          </div>
          @endif

          <hr class="my-2">

          <div class="d-flex justify-content-between fw-bold">
            <span>Total Bayar</span>
            <span class="text-success">
              Rp {{ number_format($reservasi->total_bayar,0,',','.') }}
            </span>
          </div>
        </div>
      </div>

      <!-- BUKTI -->
      <div class="mb-4">
        <h6 class="fw-bold mb-2">Bukti Pembayaran</h6>

        @if($reservasi->file_bukti_tf)
        <a href="{{ asset('storage/' . $reservasi->file_bukti_tf) }}" target="_blank"
          class="btn btn-outline-primary btn-sm">
          <i class="bi bi-image"></i> Lihat Bukti
        </a>
        @else
        <span class="badge bg-danger">Belum ada</span>
        @endif
      </div>

      <!-- ACTION -->
      <div class="d-flex justify-content-end gap-2">
        @if(in_array($reservasi->status_reservasi_wisata, ['dibayar', 'selesai']))
        <a href="{{ route('reservasi.invoice', $reservasi->id) }}" class="btn btn-success btn-sm">
          Invoice
        </a>
        <a href="{{ route('reservasi.voucher', $reservasi->id) }}" class="btn btn-primary btn-sm">
          Voucher
        </a>
        @endif
      </div>

    </div>
  </div>

</div>

@endsection
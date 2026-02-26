<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Desa Arborek Papua - Detail Reservasi</title>

  <link href="{{ asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <style>
    body {
      background-color: #f5f5f5;
    }

    .reservation-detail {
      border-radius: 10px;
      overflow: hidden;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .detail-header {
      background: linear-gradient(135deg, #ff6b6b 0%, #f7b733 100%);
      color: white;
      padding: 20px;
    }

    .detail-body {
      padding: 30px;
    }

    .status-badge {
      padding: 6px 12px;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .status-menunggu_verifikasi {
      background-color: #ffeeba;
      color: #856404;
    }

    .status-dikonfirmasi {
      background-color: #d4edda;
      color: #155724;
    }

    .status-dibatalkan {
      background-color: #f8d7da;
      color: #721c24;
    }

    .detail-section {
      margin-bottom: 30px;
    }

    .detail-section h5 {
      border-bottom: 2px solid #f0f0f0;
      padding-bottom: 10px;
      margin-bottom: 20px;
      font-weight: 600;
    }

    .detail-row {
      display: flex;
      margin-bottom: 15px;
      padding-bottom: 15px;
      border-bottom: 1px dashed #e0e0e0;
    }

    .detail-label {
      width: 180px;
      font-weight: 600;
      color: #495057;
    }

    .detail-value {
      flex: 1;
    }

    .proof-image {
      max-width: 100%;
      border-radius: 5px;
      border: 1px solid #ddd;
    }

    .payment-detail {
      background-color: #f1f8ff;
      border-left: 4px solid #007bff;
      padding: 15px;
      margin-bottom: 15px;
    }

    .body {
      background-color: rgba(179, 179, 179, 0.32);
    }
  </style>
</head>

<body class="body">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <nav>@include('fe.navbar')</nav>
  </header>

  <main id="main" class="mt-5 pt-5">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-info-circle me-2"></i>Detail Reservasi</h2>
            <a href="{{ route('reservasi.riwayat') }}" class="btn btn-outline-primary">
              <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
          </div>

          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          <div class="reservation-detail shadow">
            <div class="detail-header d-flex justify-content-between align-items-center">
              <div>
                <h4 class="mb-1">Reservasi #{{ $reservasi->id }}</h4>
                <p class="mb-0">Dibuat pada: {{ $reservasi->created_at->format('d F Y H:i') }}</p>
              </div>
              <span class="status-badge status-{{ $reservasi->status_reservasi_wisata }}">
                {{ ucwords(str_replace('_', ' ', $reservasi->status_reservasi_wisata)) }}
              </span>
            </div>
            <div class="detail-body">
              <!-- Informasi Pemesan -->
              <div class="detail-section">
                <h5><i class="bi bi-person me-2"></i>Informasi Pemesan</h5>
                <div class="detail-row">
                  <div class="detail-label">Nama Lengkap</div>
                  <div class="detail-value">{{ $reservasi->pelanggan->nama_lengkap }}</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">No. HP</div>
                  <div class="detail-value">{{ $reservasi->pelanggan->no_hp }}</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Email</div>
                  <div class="detail-value">{{ $reservasi->pelanggan->user->email }}</div>
                </div>
              </div>

              <!-- Informasi Paket -->
              <div class="detail-section">
                <h5><i class="bi bi-box me-2"></i>Informasi Paket Wisata</h5>
                <div class="detail-row">
                  <div class="detail-label">Nama Paket</div>
                  <div class="detail-value">{{ $reservasi->paketWisata->nama_paket }}</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Deskripsi</div>
                  <div class="detail-value">{{ $reservasi->paketWisata->deskripsi }}</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Harga Per Paket</div>
                  <div class="detail-value">Rp {{ number_format($reservasi->harga) }}</div>
                </div>
              </div>

              <!-- Detail Reservasi -->
              <div class="detail-section">
                <h5><i class="bi bi-calendar-event me-2"></i>Detail Reservasi</h5>
                <div class="detail-row">
                  <div class="detail-label">Tanggal Reservasi</div>
                  <div class="detail-value">{{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_wisata)->format('d F Y H:i') }}</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Jumlah Peserta</div>
                  <div class="detail-value">{{ $reservasi->jumlah_peserta }} orang</div>
                </div>
                <div class="detail-row">
                  <div class="detail-label">Status</div>
                  <div class="detail-value">
                    <span class="status-badge status-{{ $reservasi->status_reservasi_wisata }}">
                      {{ ucwords(str_replace('_', ' ', $reservasi->status_reservasi_wisata)) }}
                    </span>
                  </div>
                </div>
              </div>

              <!-- Informasi Pembayaran -->
              <div class="detail-section">
                <h5><i class="bi bi-cash-coin me-2"></i>Informasi Pembayaran</h5>
                <div class="payment-detail">
                  <div class="detail-row">
                    <div class="detail-label">Subtotal</div>
                    <div class="detail-value">Rp {{ number_format($reservasi->harga * $reservasi->jumlah_peserta) }}</div>
                  </div>
                  @if($reservasi->nilai_diskon > 0)
                  <div class="detail-row">
                    <div class="detail-label">Diskon</div>
                    <div class="detail-value">Rp {{ number_format($reservasi->nilai_diskon) }}</div>
                  </div>
                  @endif
                  <div class="detail-row mb-0 pb-0 border-bottom-0">
                    <div class="detail-label fw-bold">Total Bayar</div>
                    <div class="detail-value fw-bold">Rp {{ number_format($reservasi->total_bayar) }}</div>
                  </div>
                </div>

                <div class="detail-row">
                  <div class="detail-label">Bukti Pembayaran</div>
                  <div class="detail-value">
                    @if($reservasi->file_bukti_tf)
                    <a href="{{ request()->getSchemeAndHttpHost() . Storage::url($reservasi->file_bukti_tf) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-file-earmark-image me-1"></i>Lihat Bukti Transfer
                    </a>
                    @else
                      <span class="badge bg-danger">-</span>
                    @endif
                  </div>
                </div>
              </div>

              <!-- Tombol Aksi -->
              <div class="d-flex justify-content-end mt-4">
                @if($reservasi->status_reservasi_wisata == 'dikonfirmasi')
                <a href="{{ route('reservasi.invoice', $reservasi->id) }}" class="btn btn-success me-2">
                  <i class="bi bi-file-earmark-text me-1"></i>Invoice
                </a>
                <a href="{{ route('reservasi.voucher', $reservasi->id) }}" class="btn btn-primary">
                  <i class="bi bi-ticket-perforated me-1"></i>Voucher
                </a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="{{ asset('fe/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('fe/assets/js/main.js') }}"></script>

  @section('footer')
  @include('fe.footer')
  @endsection
</body>

</html>
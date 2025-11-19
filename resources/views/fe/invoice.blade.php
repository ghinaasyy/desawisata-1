<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Desa Arborek Papua - Invoice Reservasi</title>

  <link href="{{ asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <style>
    body {
      background-color: #f5f5f5;
    }

    .invoice-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 30px;
      background-color: #fff;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .invoice-header {
      border-bottom: 2px solid #f0f0f0;
      padding-bottom: 20px;
      margin-bottom: 30px;
    }

    .invoice-logo {
      max-height: 80px;
    }

    .invoice-title {
      font-weight: 700;
      color: #333;
      margin-bottom: 5px;
    }

    .invoice-details {
      margin-bottom: 40px;
    }

    .invoice-details-row {
      margin-bottom: 10px;
    }

    .invoice-details-label {
      font-weight: 600;
      color: #555;
    }

    .invoice-table {
      margin-bottom: 30px;
    }

    .invoice-table th {
      background-color: #f8f9fa;
      font-weight: 600;
    }

    .invoice-total {
      text-align: right;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 2px solid #f0f0f0;
    }

    .invoice-total-row {
      margin-bottom: 5px;
    }

    .invoice-total-label {
      font-weight: 600;
      display: inline-block;
      width: 150px;
      text-align: right;
      margin-right: 10px;
    }

    .invoice-total-value {
      font-weight: 600;
      display: inline-block;
      width: 120px;
      text-align: right;
    }

    .invoice-total-final {
      font-size: 1.2rem;
      font-weight: 700;
      color: #333;
    }

    .invoice-footer {
      margin-top: 40px;
      padding-top: 20px;
      border-top: 2px solid #f0f0f0;
      text-align: center;
      font-size: 0.9rem;
      color: #777;
    }

    .invoice-action {
      margin-top: 30px;
      text-align: center;
    }

    .btn-print {
      background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
      border: none;
      color: white;
      padding: 10px 20px;
      font-weight: 600;
      border-radius: 50px;
      transition: all 0.3s;
    }

    .btn-print:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
    }

    .invoice-stamp {
      text-align: center;
      margin-top: 30px;
    }

    .stamp {
      border: 2px solid #28a745;
      color: #28a745;
      display: inline-block;
      padding: 5px 15px;
      border-radius: 5px;
      font-weight: 700;
      transform: rotate(-5deg);
      font-size: 1.2rem;
      opacity: 0.8;
    }

    .body {
      background-color: rgba(179, 179, 179, 0.32);
    }

    @media print {
      body {
        background-color: #fff;
      }

      .invoice-container {
        box-shadow: none;
        padding: 0;
      }

      .invoice-action,
      .no-print {
        display: none;
      }
    }
  </style>
</head>

<body class="body">

  <header id="header" class="header d-flex align-items-center fixed-top no-print">
    <nav>@include('fe.navbar')</nav>
  </header>

  <main id="main" class="mt-5 pt-5">
    <div class="container py-5">
      <div class="invoice-container">
        <div class="invoice-header d-flex justify-content-between align-items-center">
          <div>
            <h4 class="invoice-title">INVOICE</h4>
            <p class="text-muted mb-0">No. INV-{{ $reservasi->id }}-{{ date('Ymd', strtotime($reservasi->created_at)) }}</p>
          </div>
          <div>
            <img src="{{ asset('fe/assets/img/logo.png') }}" alt="Desa Arborek Logo" class="invoice-logo">
          </div>
        </div>

        <div class="row invoice-details">
          <div class="col-md-6">
            <h5 class="mb-3">Dari:</h5>
            <p class="mb-1"><strong>Desa Arborek Papua</strong></p>
            <p class="mb-1">Kepulauan Raja Ampat</p>
            <p class="mb-1">Papua Barat, Indonesia</p>
            <p class="mb-1">Email: info@desaarborekpapua.com</p>
            <p class="mb-1">Tel: +62 812-3456-7890</p>
          </div>
          <div class="col-md-6 text-md-end">
            <h5 class="mb-3">Kepada:</h5>
            <p class="mb-1"><strong>{{ $reservasi->pelanggan->nama_lengkap }}</strong></p>
            <p class="mb-1">{{ $reservasi->pelanggan->no_hp }}</p>
            <p class="mb-1">{{ $reservasi->pelanggan->user->email }}</p>
            <div class="invoice-details-row mt-4">
              <div class="row">
                <div class="col-6 text-md-end invoice-details-label">Tanggal Invoice:</div>
                <div class="col-6 text-md-end">{{ $reservasi->created_at->format('d/m/Y') }}</div>
              </div>
              <div class="row">
                <div class="col-6 text-md-end invoice-details-label">Status:</div>
                <div class="col-6 text-md-end">
                  <span class="badge bg-success">Lunas</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="invoice-table">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Deskripsi</th>
                <th class="text-center">Jumlah</th>
                <th class="text-end">Harga Satuan</th>
                <th class="text-end">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <strong>{{ $reservasi->paketWisata->nama_paket }}</strong><br>
                  <small class="text-muted">Tanggal Reservasi: {{ \Carbon\Carbon::parse($reservasi->tgl_reservasi_wisata)->format('d F Y H:i') }}</small>
                </td>
                <td class="text-center">{{ $reservasi->jumlah_peserta }}</td>
                <td class="text-end">Rp {{ number_format($reservasi->harga) }}</td>
                <td class="text-end">Rp {{ number_format($reservasi->harga * $reservasi->jumlah_peserta) }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="invoice-total">
          <div class="invoice-total-row">
            <span class="invoice-total-label">Subtotal:</span>
            <span class="invoice-total-value">Rp {{ number_format($reservasi->harga * $reservasi->jumlah_peserta) }}</span>
          </div>
          @if($reservasi->nilai_diskon > 0)
          <div class="invoice-total-row">
            <span class="invoice-total-label">Diskon:</span>
            <span class="invoice-total-value">Rp {{ number_format($reservasi->nilai_diskon) }}</span>
          </div>
          @endif
          <div class="invoice-total-row invoice-total-final">
            <span class="invoice-total-label">Total:</span>
            <span class="invoice-total-value">Rp {{ number_format($reservasi->total_bayar) }}</span>
          </div>
        </div>

        <div class="invoice-stamp">
          <div class="stamp">LUNAS</div>
        </div>

        <div class="invoice-footer">
          <p>Terima kasih atas kepercayaan Anda menggunakan layanan kami.</p>
          <p class="mb-0">Untuk pertanyaan tentang invoice ini, silakan hubungi kami di info@desaarborekpapua.com</p>
        </div>

        <!-- Ganti bagian tombol action di bagian bawah -->
        <div class="invoice-action no-print">
          <button onclick="window.print()" class="btn btn-print">
            <i class="bi bi-printer me-2"></i>Cetak Invoice
          </button>
          <a href="{{ route('reservasi.download-invoice', $reservasi->id) }}" class="btn btn-primary ms-2">
            <i class="bi bi-download me-2"></i>Download PDF
          </a>
          <a href="{{ route('reservasi.riwayat') }}" class="btn btn-outline-secondary ms-2">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Riwayat
          </a>
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
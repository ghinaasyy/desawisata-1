<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Desa Arborek Papua</title>

  <link href="{{ asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

  <style>
    body {
      background-color: #f5f5f5;
    }

    .reservation-form {
      border-radius: 10px;
      overflow: hidden;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-header {
      background: linear-gradient(135deg, #ff6b6b 0%, #f7b733 100%);
      color: white;
      padding: 20px;
      text-align: center;
    }

    .form-body {
      padding: 30px;
    }

    .form-control,
    .form-select {
      border-radius: 5px;
      padding: 10px 15px;
      border: 1px solid #ced4da;
      transition: all 0.3s;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #ff6b6b;
      box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
    }

    .form-label {
      font-weight: 600;
      color: #495057;
    }

    .btn-submit {
      background: linear-gradient(135deg, #007bff 0%, #00a1ff 100%);
      border: none;
      padding: 10px 25px;
      font-weight: 600;
      transition: all 0.3s;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .price-display {
      background-color: #f1f8ff;
      border-left: 4px solid #007bff;
      padding: 10px 15px;
      font-weight: 600;
    }

    .readonly-field {
      background-color: #e9ecef;
      cursor: not-allowed;
    }

    .body {
      background-color: rgba(179, 179, 179, 0.32);
    }

    .voucher-status {
      margin-top: 5px;
      font-size: 0.875rem;
    }

    .voucher-valid {
      color: #28a745;
    }

    .voucher-invalid {
      color: #dc3545;
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
        <div class="col-lg-8">
          <div class="reservation-form shadow">
            <div class="form-header">
              <h4 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Form Reservasi Wisata</h4>
            </div>
            <div class="form-body">
              <form method="POST" action="{{ route('reservasi.store') }}" enctype="multipart/form-data" id="reservasiForm">
                @csrf

                <!-- Data Pelanggan -->
                <div class="mb-4">
                  <label class="form-label">Informasi Pemesan</label>
                  <div class="card p-3 mb-3">
                    <div class="row mb-2">
                      <div class="col-md-4">
                        <span class="text-muted">Nama Lengkap</span>
                      </div>
                      <div class="col-md-8">
                        <input type="text" class="form-control readonly-field"
                          value="{{ auth()->user() ? (auth()->user()->pelanggan->nama_lengkap ?? auth()->user()->name) : 'Guest' }}" readonly>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <span class="text-muted">No HP</span>
                      </div>
                      <div class="col-md-8">
                        <input type="text" class="form-control readonly-field"
                          value="{{ auth()->user() ? (auth()->user()->pelanggan->no_hp ?? '-') : '-' }}" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Pilih Paket Wisata -->
                <div class="mb-4">
                  <label for="id_paket" class="form-label">Paket Wisata</label>
                  <select name="id_paket" id="id_paket" class="form-select" required>
                    <option value="">-- Pilih Paket --</option>
                    @foreach($pakets as $paket)
                    <option value="{{ $paket->id }}" data-harga="{{ $paket->harga_per_pack }}">
                      {{ $paket->nama_paket }} - Rp {{ number_format($paket->harga_per_pack) }}
                    </option>
                    @endforeach
                  </select>
                </div>

                <!-- Tanggal Reservasi -->
                <div class="mb-4">
                  <label for="tgl_reservasi_wisata" class="form-label">Tanggal Reservasi</label>
                  <input type="datetime-local" name="tgl_reservasi_wisata" id="tgl_reservasi_wisata"
                    class="form-control" min="{{ date('Y-m-d') }}" required>
                </div>

                <!-- Jumlah Peserta -->
                <div class="mb-4">
                  <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                  <input type="number" name="jumlah_peserta" id="jumlah_peserta"
                    class="form-control" min="1" required>
                </div>

                <!-- Kode Voucher -->
                <div class="mb-4">
                  <label for="voucher_code" class="form-label">Kode Voucher (Opsional)</label>
                  <input type="text" name="voucher_code" id="voucher_code" class="form-control"
                    placeholder="Masukkan kode voucher jika ada">
                  <div id="voucherStatus" class="voucher-status"></div>
                  <input type="hidden" name="diskon" id="diskon_hidden" value="0">
                </div>

                <!-- Informasi Pembayaran -->
                <div class="mb-4">
                  <label class="form-label">Detail Pembayaran</label>
                  <div class="card p-3">
                    <div class="row mb-2">
                      <div class="col-md-4">
                        <span class="text-muted">Harga Paket</span>
                      </div>
                      <div class="col-md-8">
                        <input type="text" id="harga_paket" name="harga_paket" class="form-control price-display readonly-field" readonly>
                      </div>
                    </div>

                    <div class="row mb-2">
                      <div class="col-md-4">
                        <span class="text-muted">Diskon</span>
                      </div>
                      <div class="col-md-8">
                        <input type="text" id="nilai_diskon" name="nilai_diskon" class="form-control price-display readonly-field" readonly>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <span class="text-muted fw-bold">Total Bayar</span>
                      </div>
                      <div class="col-md-8">
                        <input type="text" name="total_bayar" id="total_bayar" class="form-control price-display readonly-field fw-bold" readonly>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Upload Bukti Transfer -->
                <div class="mb-4">
                  <label for="file_bukti_tf" class="form-label">Bukti Transfer</label>
                  <input type="file" name="file_bukti_tf" id="file_bukti_tf" class="form-control" required>
                  <div class="form-text">Upload bukti transfer pembayaran (format: JPG, PNG, PDF, maks 5MB)</div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                  <button type="submit" class="btn btn-primary btn-submit">
                    <i class="bi bi-send-check me-2"></i>Submit Reservasi
                  </button>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="{{ asset('fe/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('fe/assets/js/main.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const paketSelect = document.getElementById('id_paket');
      const jumlahPeserta = document.getElementById('jumlah_peserta');
      const voucherCode = document.getElementById('voucher_code');
      const hargaPaket = document.getElementById('harga_paket');
      const nilaiDiskon = document.getElementById('nilai_diskon');
      const totalBayar = document.getElementById('total_bayar');
      const voucherStatus = document.getElementById('voucherStatus');
      const diskonHidden = document.getElementById('diskon_hidden');

      let currentVoucher = null;

      // Fungsi untuk validasi voucher
      async function validateVoucher(code) {
        if (!code) {
          voucherStatus.textContent = '';
          currentVoucher = null;
          return;
        }

        try {
          const response = await fetch('/api/validate-voucher?code=' + encodeURIComponent(code));
          const data = await response.json();

          if (data.valid) {
            voucherStatus.textContent = 'Voucher valid: ' + data.diskon + '% diskon';
            voucherStatus.className = 'voucher-status voucher-valid';
            currentVoucher = data;
          } else {
            voucherStatus.textContent = 'Voucher tidak valid atau sudah kadaluarsa';
            voucherStatus.className = 'voucher-status voucher-invalid';
            currentVoucher = null;
          }
        } catch (error) {
          console.error('Error validating voucher:', error);
          voucherStatus.textContent = 'Gagal memvalidasi voucher';
          voucherStatus.className = 'voucher-status voucher-invalid';
          currentVoucher = null;
        }

        calculateTotal();
      }

      // Fungsi hitung total
      function calculateTotal() {
        const harga = parseInt(paketSelect.selectedOptions[0]?.dataset.harga || 0);
        const peserta = parseInt(jumlahPeserta.value || 0);
        const diskon = currentVoucher ? currentVoucher.diskon : 0;

        const subtotal = harga * peserta;
        const diskonValue = subtotal * (diskon / 100);
        const total = subtotal - diskonValue;

        hargaPaket.value = formatRupiah(subtotal);
        nilaiDiskon.value = formatRupiah(diskonValue);
        totalBayar.value = formatRupiah(total);
        diskonHidden.value = diskon;
        document.querySelector('input[name="total_bayar"]').value = total;
      }

      function formatRupiah(angka) {
        angka = isNaN(angka) ? 0 : angka;
        return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }

      // Event listeners
      paketSelect.addEventListener('change', calculateTotal);
      jumlahPeserta.addEventListener('input', calculateTotal);

      // Validasi voucher saat kode diubah
      voucherCode.addEventListener('change', function() {
        validateVoucher(this.value);
      });

      // Validasi voucher saat form disubmit
      document.getElementById('reservasiForm').addEventListener('submit', function(e) {
        if (voucherCode.value && !currentVoucher) {
          e.preventDefault();
          alert('Voucher tidak valid. Silakan periksa kembali kode voucher Anda.');
        }
      });

      // Initialize calculation on page load
      calculateTotal();
    });
  </script>

  @section('footer')
  @include('fe.footer')
  @endsection
</body>

</html>
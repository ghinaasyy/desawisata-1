@extends('fe.master')

@section('title', 'Desa Arborek Papua')

@section('content')

<div class="container py-5 mt-5">
    <style>
        /* Custom palette: replace blue with #1b3c2c (dark green), #f7c873 (gold), #fff, #e9f5ee (light green) */
        .reservasi-title {
            color: #1b3c2c;
            background: none;
        }
        .reservasi-summary-title {
            color: #1b3c2c;
        }
        .reservasi-btn {
            background: #f7c873;
            color: #1b3c2c;
            border: none;
        }
        .reservasi-btn:hover {
            background: #e9f5ee;
            color: #1b3c2c;
        }
        .reservasi-card {
            background: #fff;
        }
        .reservasi-summary-card {
            background: #e9f5ee;
        }
        /* Sticky summary: avoid navbar/footer overlap */
        @media (min-width: 992px) {
            .sticky-summary {
                position: sticky;
                top: 100px;
                z-index: 10;
                margin-bottom: 40px;
            }
        }
        @media (max-width: 991px) {
            .sticky-summary {
                position: static;
                margin-bottom: 20px;
            }
        }
        /* Prevent overlap with footer */
        footer {
            z-index: 1;
        }
    </style>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 mb-4 reservasi-card">
                <div class="card-body p-5">
                    <h2 class="mb-4 fw-bold text-center reservasi-title">
                        <i class="bi bi-calendar2-check me-2"></i>Form Reservasi Wisata
                    </h2>
                    <form action="{{ route('reservasi.store') }}" method="POST" enctype="multipart/form-data" id="reservasiForm">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold"><i class="bi bi-person-circle me-1"></i>Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control form-control-lg @error('nama_lengkap') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('nama_lengkap', (auth()->check() && optional(auth()->user())->pelanggan) ? auth()->user()->pelanggan->nama_lengkap : '') }}" required>
                                    @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold"><i class="bi bi-phone me-1"></i>Nomor HP</label>
                                    <input type="text" name="no_hp" class="form-control form-control-lg @error('no_hp') is-invalid @enderror" placeholder="Nomor HP" value="{{ old('no_hp', (auth()->check() && optional(auth()->user())->pelanggan) ? auth()->user()->pelanggan->no_hp : '') }}" required>
                                    @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-geo-alt me-1"></i>Alamat</label>
                            <textarea name="alamat" class="form-control form-control-lg @error('alamat') is-invalid @enderror" rows="2" placeholder="Alamat lengkap" required>{{ old('alamat', (auth()->check() && optional(auth()->user())->pelanggan) ? auth()->user()->pelanggan->alamat : '') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <hr class="my-4">
                        <div class="row g-4 align-items-end">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold"><i class="bi bi-bag-heart me-1"></i>Paket Wisata</label>
                                    <select name="id_paket" id="id_paket" class="form-select form-select-lg @error('id_paket') is-invalid @enderror" required>
                                        <option value="">-- Pilih Paket --</option>
                                        @foreach ($paket as $p)
                                            <option value="{{ $p->id }}" data-harga="{{ $p->harga_per_pack }}" {{ old('id_paket') == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_paket }} - Rp {{ number_format($p->harga_per_pack, 0, ',', '.') }} /orang
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_paket')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold"><i class="bi bi-calendar-event me-1"></i>Tanggal Kunjungan</label>
                                    <input type="date" name="tgl_reservasi_wisata" id="tgl_reservasi_wisata" class="form-control form-control-lg @error('tgl_reservasi_wisata') is-invalid @enderror" value="{{ old('tgl_reservasi_wisata') }}" required>
                                    @error('tgl_reservasi_wisata')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold"><i class="bi bi-people me-1"></i>Jumlah Orang</label>
                                    <input type="number" min="1" name="jumlah_peserta" id="jumlah_peserta" class="form-control form-control-lg @error('jumlah_peserta') is-invalid @enderror" value="{{ old('jumlah_peserta', 1) }}" required>
                                    @error('jumlah_peserta')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-file-earmark-image me-1"></i>Upload Bukti Transfer <span class="text-muted">(opsional)</span></label>
                            <input type="file" name="file_bukti_tf" class="form-control form-control-lg @error('file_bukti_tf') is-invalid @enderror" accept="image/*,application/pdf">
                            @error('file_bukti_tf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <input type="hidden" name="harga" id="harga_input" value="{{ old('harga', '') }}">
                        <input type="hidden" name="diskon" id="diskon_input" value="0">
                        <input type="hidden" name="nilai_diskon" id="nilai_diskon_input" value="0">
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn reservasi-btn btn-lg fw-bold shadow-sm">
                                <i class="bi bi-check2-circle me-1"></i> Buat Reservasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow rounded-4 sticky-summary reservasi-summary-card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3 reservasi-summary-title"><i class="bi bi-receipt me-1"></i>Ringkasan Harga</h5>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Harga per orang</span>
                            <strong id="harga_per_orang">-</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Jumlah orang</span>
                            <strong id="summary_jumlah">1</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Diskon</span>
                            <strong id="summary_diskon">0</strong>
                        </li>
                    </ul>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="h5 mb-0">Total bayar</span>
                        <strong class="h5 mb-0" id="summary_total">-</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paketSelect = document.getElementById('id_paket');
        const jumlahInput = document.getElementById('jumlah_peserta');
        const hargaPerOrangEl = document.getElementById('harga_per_orang');
        const summaryJumlahEl = document.getElementById('summary_jumlah');
        const summaryDiskonEl = document.getElementById('summary_diskon');
        const summaryTotalEl = document.getElementById('summary_total');
        const hargaInput = document.getElementById('harga_input');

        function formatRupiah(value) {
            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateSummary() {
            const opt = paketSelect.options[paketSelect.selectedIndex];
            const hargaPerOrang = opt ? parseInt(opt.dataset.harga || 0, 10) : 0;
            const jumlah = parseInt(jumlahInput.value || 0, 10) || 0;
            const total = hargaPerOrang * jumlah;

            hargaPerOrangEl.textContent = hargaPerOrang ? formatRupiah(hargaPerOrang) : '-';
            summaryJumlahEl.textContent = jumlah;
            summaryDiskonEl.textContent = '0';
            summaryTotalEl.textContent = total ? formatRupiah(total) : '-';

            // set hidden inputs
            hargaInput.value = hargaPerOrang;
            document.getElementById('diskon_input').value = 0;
            document.getElementById('nilai_diskon_input').value = 0;
        }

        paketSelect && paketSelect.addEventListener('change', updateSummary);
        jumlahInput && jumlahInput.addEventListener('input', updateSummary);

        // initial run
        updateSummary();
    });
</script>
@endpush
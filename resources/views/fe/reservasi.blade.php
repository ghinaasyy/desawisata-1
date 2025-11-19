@extends('fe.master')

@section('title', 'Reservasi')

@push('styles')
<style>
    .form-section {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .form-section h4 {
        font-weight: 600;
        margin-bottom: 18px;
    }

    .total-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e3e3e3;
    }
</style>
@endpush

@section('content')
<div class="container py-5">

    <h2 class="mb-4 fw-bold text-center">Form Reservasi</h2>

    <div class="row g-4">

        {{-- FORM --}}
        <div class="col-lg-8">
            <div class="form-section">

                <form action="{{ route('reservasi.store') }}" method="POST">
                    @csrf

                    {{-- 1. Data Diri --}}
                    <h4>Data Diri Pemesan</h4>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                            value="{{ old('telepon') }}" required>
                        @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    {{-- 2. Detail Reservasi --}}
                    <h4>Detail Reservasi</h4>

                    <div class="mb-3">
                        <label class="form-label">Paket Wisata</label>
                        <select name="paket_id" class="form-select @error('paket_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Paket --</option>
                            @foreach ($paket as $p)
                                <option value="{{ $p->id }}"
                                    {{ old('paket_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_paket }} - Rp {{ number_format($p->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('paket_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Kunjungan</label>
                            <input type="date" name="tanggal"
                                class="form-control @error('tanggal') is-invalid @enderror"
                                value="{{ old('tanggal') }}" required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah Orang</label>
                            <input type="number" min="1" name="jumlah_orang"
                                class="form-control @error('jumlah_orang') is-invalid @enderror"
                                value="{{ old('jumlah_orang', 1) }}" required>
                            @error('jumlah_orang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                        Buat Reservasi
                    </button>
                </form>

            </div>
        </div>

        {{-- TOTAL --}}
        <div class="col-lg-4">
            <div class="total-box">
                <h5 class="fw-bold mb-3">Ringkasan Harga</h5>

                <p class="text-muted mb-1">Harga otomatis dihitung pada langkah berikutnya.</p>
                <small>Setelah menekan *Buat Reservasi*, sistem akan menampilkan total harga.</small>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    // jika ingin menambahkan JS kalkulasi harga otomatis di frontend, tempatnya di sini.
</script>
@endpush
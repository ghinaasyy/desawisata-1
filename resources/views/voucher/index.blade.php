@extends('be.master')
@section('navbar')
@include('be.navbar')
@endsection
@section('sidebar')
@include('be.sidebar')
@endsection
@section('content')

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Voucher</h4>
                    <p class="mb-0">Manajemen Voucher</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('voucher.index') }}">Voucher</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Voucher</h4>
                        <a href="{{ route('voucher.create') }}" class="btn btn-primary float-right">
                            <i class="fas fa-plus"></i> Tambah Voucher
                        </a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Promo</th>
                                        <th>Nilai Diskon</th>
                                        <th>Tipe</th>
                                        <th>Min. Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Kuota</th>
                                        <th>Dipakai</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vouchers as $voucher)
                                    <tr>
                                        <td>{{ $voucher->kode }}</td>
                                        <td>{{ $voucher->nama_promo }}</td>

                                        <td>
                                            @if($voucher->jenis_diskon == 'persentase')
                                                {{ $voucher->nilai_diskon }}%
                                            @else
                                                Rp {{ number_format($voucher->nilai_diskon) }}
                                            @endif
                                        </td>

                                        <td>{{ ucfirst($voucher->jenis_diskon) }}</td>
                                        <td>Rp {{ number_format($voucher->minimal_transaksi) }}</td>

                                        <td>
                                            {{ \Carbon\Carbon::parse($voucher->tanggal_mulai)->format('d M Y') }}
                                            <br> -
                                            {{ \Carbon\Carbon::parse($voucher->tanggal_berakhir)->format('d M Y') }}
                                        </td>

                                        <td>{{ $voucher->kuota }}</td>
                                        <td>{{ $voucher->digunakan }}</td>

                                        <td>
                                            @if(now()->between($voucher->tanggal_mulai, $voucher->tanggal_berakhir))
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ route('voucher.edit', $voucher->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('voucher.destroy', $voucher->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus voucher ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footer')
@include('be.footer')
@endsection
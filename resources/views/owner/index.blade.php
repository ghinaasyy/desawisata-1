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

    {{-- HEADER --}}
    <div class="row page-titles mx-0 mb-4">
        <div class="col-sm-6">
            <h4>Dashboard Owner</h4>
        </div>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="mb-3">
        <select name="filter" onchange="this.form.submit()" class="form-control w-auto">
            <option value="hari" {{ $filter=='hari'?'selected':'' }}>Hari Ini</option>
            <option value="minggu" {{ $filter=='minggu'?'selected':'' }}>Minggu Ini</option>
            <option value="bulan" {{ $filter=='bulan'?'selected':'' }}>Bulan Ini</option>
            <option value="tahun" {{ $filter=='tahun'?'selected':'' }}>Tahun Ini</option>
        </select>
    </form>

    {{-- STATISTIK --}}
    <div class="row mb-4">

        <div class="col-md-2">
            <div class="card p-3">
                <h6>Reservasi</h6>
                <h4>{{ $totalReservasi }}</h4>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card p-3">
                <h6>Pendapatan</h6>
                <h4>Rp {{ number_format((float)$totalPendapatan,0,',','.') }}</h4>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card p-3">
                <h6>User</h6>
                <h4>{{ $totalUser }}</h4>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card p-3">
                <h6>Pelanggan</h6>
                <h4>{{ $totalPelanggan }}</h4>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card p-3">
                <h6>Paket</h6>
                <h4>{{ $totalPaket }}</h4>
            </div>
        </div>

    </div>

    {{-- PDF --}}
    <a href="{{ route('owner.export.pdf', ['filter'=>$filter]) }}" class="btn btn-danger mb-3">
        Download PDF
    </a>

    {{-- RESERVASI --}}
    <div class="card mb-4">
        <div class="card-header">Reservasi Terbaru</div>
        <div class="card-body">
            <table class="table">
                @foreach($reservasiTerbaru as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ optional($r->pelanggan)->nama_lengkap }}</td>
                    <td>Rp {{ number_format((float)$r->total_bayar,0,',','.') }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    {{-- USER --}}
    <div class="card mb-4">
        <div class="card-header">User Terbaru</div>
        <div class="card-body">
            <table class="table">
                @foreach($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

    {{-- PELANGGAN --}}
    <div class="card">
        <div class="card-header">Pelanggan Terbaru</div>
        <div class="card-body">
            <table class="table">
                @foreach($pelangganList as $p)
                <tr>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->no_hp }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>

</div>
</div>
@endsection

@section('footer')
@include('be.footer')
@endsection
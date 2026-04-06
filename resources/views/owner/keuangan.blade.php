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
    <div class="row page-titles mx-0 mb-3">
        <div class="col-sm-6">
            <h4>Data Keuangan</h4>
        </div>
    </div>

    {{-- FILTER --}}
    <form method="GET" class="mb-3">
        <select name="filter" onchange="this.form.submit()" class="form-control w-auto">
            <option value="hari" {{ $filter=='hari'?'selected':'' }}>Hari</option>
            <option value="minggu" {{ $filter=='minggu'?'selected':'' }}>Minggu</option>
            <option value="bulan" {{ $filter=='bulan'?'selected':'' }}>Bulan</option>
            <option value="tahun" {{ $filter=='tahun'?'selected':'' }}>Tahun</option>
        </select>
    </form>

    <h5 class="mb-3">
        Total: Rp {{ number_format((float)$totalPendapatan,0,',','.') }}
    </h5>

    <a href="{{ route('owner.export.pdf', ['filter'=>$filter]) }}" class="btn btn-danger mb-3">
        Download PDF
    </a>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                @foreach($reservasi as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ optional($r->pelanggan)->nama_lengkap }}</td>
                    <td>Rp {{ number_format((float)$r->total_bayar,0,',','.') }}</td>
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
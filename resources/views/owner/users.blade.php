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
            <h4>Data User</h4>
            <p class="mb-0">Daftar user & pelanggan</p>
        </div>
    </div>

    {{-- USER --}}
    <div class="card mb-4">
        <div class="card-header">
            <h5>User</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
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
        <div class="card-header">
            <h5>Pelanggan</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                @foreach($pelanggan as $p)
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
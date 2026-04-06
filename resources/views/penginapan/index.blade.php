@php
use Illuminate\Support\Str;
@endphp

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
                    <h4>Daftar Penginapan</h4>
                    <p class="mb-0">Manajemen Penginapan</p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('penginapan.index') }}">Penginapan</a></li>
                </ol>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Penginapan</h4>
                <a href="{{ route('penginapan.create') }}" class="btn btn-primary btn-sm float-right">Tambah Penginapan</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Penginapan</th>
                                <th class="text-center">Deskripsi</th>
                                <th class="text-center">Fasilitas</th>
                                <th class="text-center">Foto 1</th>
                                <th class="text-center">Foto 2</th>
                                <th class="text-center">Foto 3</th>
                                <th class="text-center">Foto 4</th>
                                <th class="text-center">Foto 5</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penginapans as $penginapan)
                            <tr class="text-bold text-dark">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $penginapan->nama_penginapan }}</td>
                                <td>{{ Str::limit($penginapan->deskripsi, 50) }}</td>
                                <td>{{ Str::limit($penginapan->fasilitas, 30) }}</td>
                                @for($i = 1; $i <= 5; $i++)
                                    <td>
                                        @if ($penginapan->{'foto'.$i})
                                        <!-- Thumbnail -->
                                        <img src="{{$penginapan->{'foto'.$i} }}" alt="Foto {{ $i }}" style="width: 50px; cursor: pointer;"
                                            class="img-thumbnail" data-toggle="modal" data-target="#foto{{ $i }}Modal_{{ $penginapan->id }}">
                                       
                                        <!-- Modal -->
                                        <div class="modal fade" id="foto{{ $i }}Modal_{{ $penginapan->id }}" tabindex="-1" role="dialog" aria-labelledby="foto{{ $i }}ModalLabel_{{ $penginapan->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="foto{{ $i }}ModalLabel_{{ $penginapan->id }}">Foto {{ $i }} - {{ $penginapan->nama_penginapan }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ asset('storage/' . $penginapan->{'foto'.$i}) }}" alt="Foto {{ $i }}" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                @endfor
                                <td class="text-center">
                                    <a href="{{ route('penginapan.edit', $penginapan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('penginapan.destroy', $penginapan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
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
@endsection
@section('footer')
@include('be.footer')
@endsection
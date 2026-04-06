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
<div class="col-sm-6">
<h4>Edit Voucher</h4>
</div>
</div>

<div class="card">
<div class="card-body">

<form action="{{ route('voucher.update',$voucher->id) }}" method="POST" id="voucherForm">
@csrf
@method('PUT')

<div class="row">

<div class="col-md-6">
<label>Kode Voucher</label>
<input type="text" name="kode" value="{{ $voucher->kode }}" class="form-control" required>
</div>

<div class="col-md-6">
<label>Nama Promo</label>
<input type="text" name="nama_promo" value="{{ $voucher->nama_promo }}" class="form-control" required>
</div>

<div class="col-12">
<label>Detail Promo</label>
<textarea name="detail_promo" class="form-control">{{ $voucher->detail_promo }}</textarea>
</div>

<div class="col-md-6">
<label>Tanggal Mulai</label>
<input type="date" name="tanggal_mulai" value="{{ $voucher->tanggal_mulai->format('Y-m-d') }}" class="form-control">
</div>

<div class="col-md-6">
<label>Tanggal Berakhir</label>
<input type="date" name="tanggal_berakhir" value="{{ $voucher->tanggal_berakhir->format('Y-m-d') }}" class="form-control">
</div>

<div class="col-md-6">
<label>Minimal Transaksi</label>
<input type="number" name="minimal_transaksi" value="{{ $voucher->minimal_transaksi }}" class="form-control">
</div>

<div class="col-md-6">
<label>Tipe Diskon</label>
<select name="jenis_diskon" id="jenis_diskon" class="form-control">
<option value="persentase" {{ $voucher->jenis_diskon=='persentase'?'selected':'' }}>Persentase</option>
<option value="nominal" {{ $voucher->jenis_diskon=='nominal'?'selected':'' }}>Nominal</option>
</select>
</div>

<div class="col-md-6">
<label id="label_nilai">Nilai Diskon</label>
<input type="number" name="nilai_diskon" value="{{ $voucher->nilai_diskon }}" class="form-control">
</div>

<div class="col-md-6" id="maksimal_wrapper">
<label>Maksimal Diskon</label>
<input type="number" name="maksimal_diskon" value="{{ $voucher->maksimal_diskon }}" class="form-control">
</div>

<div class="col-md-6">
<label>Kuota</label>
<input type="number" name="kuota" value="{{ $voucher->kuota }}" class="form-control">
</div>

<div class="col-md-6">
<label>Digunakan</label>
<input type="number" name="digunakan" value="{{ $voucher->digunakan }}" class="form-control">
</div>

<div class="col-12 mt-3">
<button class="btn btn-primary">Update</button>
<a href="{{ route('voucher.index') }}" class="btn btn-light">Batal</a>
</div>

</div>
</form>

</div>
</div>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

const jenis = document.getElementById('jenis_diskon');
const label = document.getElementById('label_nilai');
const maxWrap = document.getElementById('maksimal_wrapper');

function updateForm(){
if(jenis.value === 'persentase'){
label.innerText = 'Nilai Diskon (%)';
maxWrap.style.display = 'block';
}else{
label.innerText = 'Nilai Diskon (Rp)';
maxWrap.style.display = 'none';
}
}

jenis.addEventListener('change', updateForm);
updateForm();

});
</script>

@endsection
@section('footer')
@include('be.footer')
@endsection
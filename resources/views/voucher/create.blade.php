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
<h4>Tambah Voucher</h4>
</div>
</div>

<div class="card">
<div class="card-body">

<form action="{{ route('voucher.store') }}" method="POST" id="voucherForm">
@csrf

<div class="row">

<div class="col-md-6">
<label>Kode Voucher</label>
<input type="text" name="kode" class="form-control" required>
</div>

<div class="col-md-6">
<label>Nama Promo</label>
<input type="text" name="nama_promo" class="form-control" required>
</div>

<div class="col-12">
<label>Detail Promo</label>
<textarea name="detail_promo" class="form-control" required></textarea>
</div>

<div class="col-md-6">
<label>Tanggal Mulai</label>
<input type="date" name="tanggal_mulai" class="form-control" required>
</div>

<div class="col-md-6">
<label>Tanggal Berakhir</label>
<input type="date" name="tanggal_berakhir" class="form-control" required>
</div>

<div class="col-md-6">
<label>Minimal Transaksi</label>
<input type="number" name="minimal_transaksi" class="form-control" required>
</div>

<div class="col-md-6">
<label>Tipe Diskon</label>
<select name="jenis_diskon" id="jenis_diskon" class="form-control" required>
<option value="">-- Pilih --</option>
<option value="persentase">Persentase (%)</option>
<option value="nominal">Nominal (Rp)</option>
</select>
</div>

<div class="col-md-6">
<label id="label_nilai">Nilai Diskon</label>
<input type="number" name="nilai_diskon" id="nilai_diskon" class="form-control" required>
<small id="hint_nilai"></small>
</div>

<div class="col-md-6" id="maksimal_wrapper">
<label>Maksimal Diskon</label>
<input type="number" name="maksimal_diskon" class="form-control">
</div>

<div class="col-md-6">
<label>Kuota</label>
<input type="number" name="kuota" class="form-control" required>
</div>

<div class="col-12 mt-3">
<button class="btn btn-primary" id="submitBtn">Simpan</button>
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
const hint = document.getElementById('hint_nilai');
const maxWrap = document.getElementById('maksimal_wrapper');

function updateForm(){
if(jenis.value === 'persentase'){
label.innerText = 'Nilai Diskon (%)';
hint.innerText = 'Contoh: 10 = 10%';
maxWrap.style.display = 'block';
}else{
label.innerText = 'Nilai Diskon (Rp)';
hint.innerText = 'Contoh: 50000';
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
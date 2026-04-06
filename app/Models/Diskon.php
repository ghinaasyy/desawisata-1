<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    protected $fillable = [
        'nama_promo',
        'kode',
        'detail_promo',
        'tanggal_mulai',
        'tanggal_berakhir',
        'minimal_transaksi',
        'jenis_diskon',
        'nilai_diskon',
        'maksimal_diskon',
        'kuota',
        'digunakan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];
}

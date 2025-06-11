<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'diskons';
    protected $fillable = [
        'kode',
        'nama_promo',
        'jenis_diskon',
        'nilai_diskon',
        'minimal_transaksi',
        'detail_promo',
        'tanggal_mulai',
        'tanggal_berakhir',
        'kuota',
        'digunakan',
        'is_active'
    ];

    protected $dates = [
        'tanggal_mulai',
        'tanggal_berakhir'
    ];

    public function reservasis()
    {
        return $this->hasMany(Reservasi::class);
    }

    public function isValid()
    {
        return $this->tanggal_berakhir >= now() && $this->digunakan < $this->kuota;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    use HasFactory;

    protected $table = 'diskons';

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
        'nilai_diskon' => 'decimal:2',
        'minimal_transaksi' => 'integer',
        'kuota' => 'integer',
        'digunakan' => 'integer'
    ];

    // Relasi ke reservasi
    public function reservasis()
    {
        return $this->hasMany(Reservasi::class, 'diskon_id');
    }

    // Scope untuk voucher aktif
    public function scopeAktif($query)
    {
        return $query->where('tanggal_mulai', '<=', now())
                    ->where('tanggal_berakhir', '>=', now())
                    ->where(function($q) {
                        $q->whereNull('kuota')
                          ->orWhereRaw('digunakan < kuota');
                    });
    }
}
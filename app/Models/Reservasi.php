<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasis';

    protected $fillable = [
        'id_pelanggan',
        'id_paket',
        'tgl_reservasi_wisata',
        'harga',
        'jumlah_peserta',
        'diskon', // decimal(10,0) - sebagai flag
        'nilai_diskon', // float(10,2) - nilai nominal diskon
        'total_bayar',
        'file_bukti_tf',
        'status_reservasi_wisata'
    ];

    // Casting tipe data
    protected $casts = [
        'tgl_reservasi_wisata' => 'datetime',
        'diskon' => 'decimal:0',
        'nilai_diskon' => 'float',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class, 'id_paket');
    }

}

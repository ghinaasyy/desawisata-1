<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pelanggan');
            $table->unsignedBigInteger('id_paket');
            $table->dateTime('tgl_reservasi_wisata')->nullable();
            $table->integer('harga'); // snapshot harga dari paket
            $table->integer('jumlah_peserta');
            $table->decimal('diskon', 10, 0)->nullable()->default(0);
            $table->decimal('nilai_diskon', 10, 2)->nullable()->default(0);
            $table->bigInteger('total_bayar');
            $table->text('file_bukti_tf')->nullable();
            $table->enum('status_reservasi_wisata', ['pesan', 'dibayar', 'selesai'])->default('pesan');
            $table->timestamps();

            $table->foreign('id_pelanggan')->references('id')->on('pelanggans')->onDelete('cascade');
            $table->foreign('id_paket')->references('id')->on('paket_wisatas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};

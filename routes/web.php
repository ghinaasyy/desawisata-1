<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

// Route Publik
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Autentikasi
Route::middleware(['guest'])->group(function(){
    Route::get('/register', [App\Http\Controllers\RegisterController::class, 'index'])->name('register');
    Route::post('/register', [App\Http\Controllers\RegisterController::class, 'store']);
    
    Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);
});

// Route yang membutuhkan autentikasi
Route::middleware(['auth'])->group(function(){
    // Dashboard berdasarkan role
    Route::prefix('admin')->middleware('userAkses:admin')->group(function() {
        Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
        Route::resource('/users', App\Http\Controllers\UsersController::class);
        Route::resource('/karyawan', App\Http\Controllers\KaryawanController::class);
        Route::resource('/pelanggan', App\Http\Controllers\PelangganController::class);
        Route::resource('/berita', App\Http\Controllers\BeritaController::class);
        Route::resource('/kategoriberita', App\Http\Controllers\KategoriBeritaController::class);
    });
    
    Route::prefix('bendahara')->middleware('userAkses:bendahara')->group(function() {
        Route::get('/', [App\Http\Controllers\BendaharaController::class, 'index'])->name('bendahara.index');
        Route::resource('/penginapan', App\Http\Controllers\PenginapanController::class);
        Route::resource('/obyekwisata', App\Http\Controllers\ObyekWisataController::class);
        Route::resource('/kategoriwisata', App\Http\Controllers\KategoriWisataController::class);
        Route::resource('/paketwisata', App\Http\Controllers\PaketWisataController::class);
        Route::resource('/voucher', App\Http\Controllers\VoucherController::class);
        Route::resource('/diskon', App\Http\Controllers\DiskonController::class)->except(['index']);
    });
    
    Route::prefix('owner')->middleware('userAkses:owner')->group(function() {
        Route::get('/', [App\Http\Controllers\OwnerController::class, 'index'])->name('owner.index');
    });

    // Route umum untuk semua role
    Route::post('/logout', function() {
        Auth::logout();
        return redirect('/');
    })->name('logout');
    
    Route::resource('resetpassword', App\Http\Controllers\ResetPasswordController::class);
    
    // Reservasi
    Route::prefix('reservasi')->group(function() {
        Route::get('/', [App\Http\Controllers\ReservasiController::class, 'index'])->name('reservasi.index');
        Route::post('/', [App\Http\Controllers\ReservasiController::class, 'store'])->name('reservasi.store');
        Route::get('riwayat', [App\Http\Controllers\ReservasiController::class, 'riwayat'])->name('reservasi.riwayat');
        Route::get('{id}/invoice', [App\Http\Controllers\ReservasiController::class, 'invoice'])->name('reservasi.invoice');
        Route::get('{id}/download-invoice', [App\Http\Controllers\ReservasiController::class, 'downloadInvoice'])->name('reservasi.download-invoice');
    });
    
    // Konfirmasi Reservasi khusus bendahara
    Route::middleware(['auth', 'role:bendahara'])->group(function () {
        Route::get('/konfirmasireservasi', [App\Http\Controllers\KonfirmasiReservasiController::class, 'index'])->name('konfirmasireservasi.index');
        Route::get('/konfirmasireservasi/{id}', [App\Http\Controllers\KonfirmasiReservasiController::class, 'show'])->name('konfirmasireservasi.show');
        Route::patch('/konfirmasireservasi/{id}/status', [App\Http\Controllers\KonfirmasiReservasiController::class, 'updateStatus'])->name('konfirmasireservasi.updateStatus');
    });

    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // Diskon untuk semua user (kecuali index yang sudah dihandle bendahara)
    Route::get('/diskon', [App\Http\Controllers\DiskonController::class, 'index'])->name('diskon.index');
    Route::post('/diskon/claim/{id}', [App\Http\Controllers\DiskonController::class, 'claim'])->name('diskon.claim');
});

// Route Frontend (tidak memerlukan auth)
Route::get('/reservasi', [App\Http\Controllers\ReservasiController::class, 'index'])->name('fe.reservasi');
Route::get('/riwayat-reservasi/{id}', [App\Http\Controllers\ReservasiController::class, 'showRiwayat'])->name('fe.riwayatreservasi');
Route::get('/invoice/{id}', [App\Http\Controllers\ReservasiController::class, 'downloadInvoicePublic'])->name('fe.invoice');

// Home route
Route::get('/home', function () {
    return view('home.index', ['title' => 'Home']);
})->name('home.index');
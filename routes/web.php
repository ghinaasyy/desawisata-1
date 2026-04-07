<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================
// ROUTE PUBLIK
// ==========================
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ==========================
// AUTH
// ==========================
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [App\Http\Controllers\RegisterController::class, 'index'])->name('register');
    Route::post('/register', [App\Http\Controllers\RegisterController::class, 'store']);

    Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);
});

// ==========================
// AUTH REQUIRED
// ==========================
Route::middleware(['auth'])->group(function () {

    // ==========================
    // ADMIN
    // ==========================
    Route::prefix('admin')->middleware('userAkses:admin')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
        Route::resource('/users', App\Http\Controllers\UsersController::class);
        Route::resource('/karyawan', App\Http\Controllers\KaryawanController::class);
        Route::resource('/pelanggan', App\Http\Controllers\PelangganController::class);
        Route::resource('/berita', App\Http\Controllers\BeritaController::class);
        Route::resource('/kategoriberita', App\Http\Controllers\KategoriBeritaController::class);
    });

    // ==========================
    // BENDAHARA
    // ==========================
    Route::prefix('bendahara')->middleware('userAkses:bendahara')->group(function () {
        Route::get('/', [App\Http\Controllers\BendaharaController::class, 'index'])->name('bendahara.index');
        Route::resource('/penginapan', App\Http\Controllers\PenginapanController::class);
        Route::resource('/obyekwisata', App\Http\Controllers\ObyekWisataController::class);
        Route::resource('/kategoriwisata', App\Http\Controllers\KategoriWisataController::class);
        Route::resource('/paketwisata', App\Http\Controllers\PaketWisataController::class);
        Route::resource('/voucher', App\Http\Controllers\VoucherController::class);
        Route::resource('/diskon', App\Http\Controllers\DiskonController::class)->except(['index']);
    });

    // ==========================
    // OWNER
    // ==========================
    Route::prefix('owner')->group(function () {
        Route::get('/', [App\Http\Controllers\OwnerController::class, 'index'])->name('owner.index');
        Route::get('/users', [App\Http\Controllers\OwnerController::class, 'users'])->name('owner.users');
        Route::get('/keuangan', [App\Http\Controllers\OwnerController::class, 'keuangan'])->name('owner.keuangan');
        Route::get('/export-pdf', [App\Http\Controllers\OwnerController::class, 'exportPdf'])->name('owner.export.pdf');
    });

    // ==========================
    // KONFIRMASI RESERVASI (FIX UTAMA DI SINI)
    // ==========================
    Route::prefix('konfirmasireservasi')
        ->middleware('userAkses:bendahara')
        ->group(function () {

            Route::get('/', [App\Http\Controllers\KonfirmasiReservasiController::class, 'index'])
                ->name('konfirmasireservasi.index');

            Route::get('/{id}', [App\Http\Controllers\KonfirmasiReservasiController::class, 'show'])
                ->name('konfirmasireservasi.show');

            Route::patch('/{id}/status', [App\Http\Controllers\KonfirmasiReservasiController::class, 'updateStatus'])
                ->name('konfirmasireservasi.updateStatus');
        });

    // ==========================
    // RESERVASI (FRONTEND USER)
    // ==========================
    Route::prefix('reservasi')->group(function () {

        Route::get('/', [App\Http\Controllers\ReservasiController::class, 'index'])->name('reservasi.index');
        Route::post('/', [App\Http\Controllers\ReservasiController::class, 'store'])->name('reservasi.store');
        Route::get('/riwayat', [App\Http\Controllers\ReservasiController::class, 'riwayat'])->name('reservasi.riwayat');

        Route::get('/{id}', [App\Http\Controllers\ReservasiController::class, 'show'])->name('reservasi.show');

        Route::get('/{id}/success', [App\Http\Controllers\ReservasiController::class, 'success'])->name('reservasi.success');
        Route::get('/{id}/invoice', [App\Http\Controllers\ReservasiController::class, 'invoice'])->name('reservasi.invoice');
        Route::get('/{id}/download-invoice', [App\Http\Controllers\ReservasiController::class, 'downloadInvoice'])->name('reservasi.download-invoice');

        Route::get('/invoice-public/{id}', [App\Http\Controllers\ReservasiController::class, 'downloadInvoicePublic'])->name('reservasi.invoice.public');
    });

    // ==========================
    // PROFILE
    // ==========================
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    // ==========================
    // LOGOUT
    // ==========================
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');

    Route::resource('resetpassword', App\Http\Controllers\ResetPasswordController::class);
});

// ==========================
// FRONTEND PUBLIC
// ==========================
Route::get('/reservasi', [App\Http\Controllers\ReservasiController::class, 'index'])->name('fe.reservasi');
Route::get('/riwayat-reservasi/{id}', [App\Http\Controllers\ReservasiController::class, 'showRiwayat'])->name('fe.riwayatreservasi');
Route::get('/invoice/{id}', [App\Http\Controllers\ReservasiController::class, 'downloadInvoicePublic'])->name('fe.invoice');
Route::get('/reservasi-sukses/{id}', [App\Http\Controllers\ReservasiController::class, 'sukses'])->name('fe.reservasi-sukses');

// ==========================
// DISKON CHECK
// ==========================
Route::post('/cek-diskon', [App\Http\Controllers\DiskonController::class, 'cek']);
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diskon;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;

class DiskonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diskons = Diskon::where('tanggal_berakhir', '>=', now())
            ->whereColumn('digunakan', '<', 'kuota')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('fe.diskon', compact('diskons'));
    }

    public function claim(Request $request, $id)
    {
        // Validate user is authenticated
        if (!Auth::check()) {
            return $this->jsonError('Anda harus login terlebih dahulu');
        }

        // Get or create pelanggan
        $pelanggan = $this->getOrCreatePelanggan(Auth::user());
        if (!$pelanggan) {
            return $this->jsonError('Gagal membuat data pelanggan');
        }

        // Process voucher claim
        return $this->processVoucherClaim($pelanggan, $id);
    }

    protected function getOrCreatePelanggan($user)
    {
        if ($user->pelanggan) {
            return $user->pelanggan;
        }

        return Pelanggan::create([
            'id_user' => $user->id,
            'nama_lengkap' => $user->name,
            'no_hp' => '-',
            'alamat' => '-',
            'foto' => null,
            'voucher_claimed' => json_encode([])
        ]);
    }

    protected function processVoucherClaim($pelanggan, $voucherId)
    {
        try {
            $diskon = Diskon::findOrFail($voucherId);

            // Validate voucher
            $validation = $this->validateVoucher($diskon, $pelanggan);
            if ($validation !== true) {
                return $validation;
            }

            // Record voucher claim
            $this->recordVoucherClaim($pelanggan, $diskon);

            return $this->jsonSuccess('Voucher berhasil diklaim!');

        } catch (\Exception $e) {
            return $this->jsonError('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    protected function validateVoucher($diskon, $pelanggan)
    {
        if ($diskon->tanggal_berakhir < now()) {
            return $this->jsonError('Voucher sudah kadaluarsa');
        }

        if ($diskon->digunakan >= $diskon->kuota) {
            return $this->jsonError('Kuota voucher sudah habis');
        }

        if ($this->hasClaimedVoucher($pelanggan, $diskon->id)) {
            return $this->jsonError('Anda sudah mengklaim voucher ini');
        }

        return true;
    }

    protected function hasClaimedVoucher($pelanggan, $voucherId)
    {
        $claimedVouchers = json_decode($pelanggan->voucher_claimed ?? '[]', true);
        
        return collect($claimedVouchers)
            ->contains('diskon_id', $voucherId);
    }

    protected function recordVoucherClaim($pelanggan, $diskon)
    {
        $claimedVouchers = json_decode($pelanggan->voucher_claimed ?? '[]', true);
        
        $claimedVouchers[] = [
            'diskon_id' => $diskon->id,
            'claimed_at' => now()->toDateTimeString(),
            'used' => false
        ];

        $pelanggan->update([
            'voucher_claimed' => json_encode($claimedVouchers)
        ]);

        $diskon->increment('digunakan');
    }

    protected function jsonSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    protected function jsonError($message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], 400);
    }
}
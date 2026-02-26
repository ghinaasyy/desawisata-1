<!-- invoice preview page with master layout -->

@extends('fe.master')

@section('content')
<div class="container py-5 mt-5" style="padding-top:90px; padding-bottom:150px;">
    <div style="max-width:800px;margin:0 auto;background:#fff;padding:28px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">
        <div style="text-align:center;margin-bottom:12px;">
            <h2 style="margin:0;font-weight:700;letter-spacing:1px;">DESA WISATA</h2>
            <div style="font-size:14px;margin-top:4px;color:#333">NOTA RESERVASI</div>
            <div style="font-weight:700;margin-top:6px;">No: {{ 'NOTA-' . str_pad($reservasi->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>

        <hr style="border:none;border-top:2px solid #111;margin:12px 0 18px;">

        <table style="width:100%;margin-bottom:18px;font-size:14px;">
            <tr>
                <td style="vertical-align:top;padding:4px 8px;width:45%;">
                    <div style="margin-bottom:8px;"><strong>Nama Pelanggan</strong> &nbsp;: {{ optional($reservasi->pelanggan)->nama_lengkap ?? '-' }}</div>
                    <div style="margin-bottom:8px;"><strong>Tanggal Reservasi</strong> &nbsp;: {{ optional($reservasi->tgl_reservasi_wisata) ? $reservasi->tgl_reservasi_wisata->format('d/m/Y') : '-' }}</div>
                    @if(isset($reservasi->durasi_hari))
                        <div style="margin-bottom:8px;"><strong>Durasi Liburan</strong> &nbsp;: {{ $reservasi->durasi_hari }} hari</div>
                    @endif
                </td>
                <td style="vertical-align:top;padding:4px 8px;width:55%;text-align:right;">
                    {{-- right column left intentionally empty for spacing --}}
                </td>
            </tr>
        </table>

        <table style="width:100%;border-collapse:collapse;margin-bottom:12px;font-size:13px;">
            <thead>
                <tr style="background:#f5f5f5;">
                    <th style="padding:10px;border:1px solid #ddd;text-align:left;">Rincian</th>
                    <th style="padding:10px;border:1px solid #ddd;text-align:center;width:160px;">Jumlah</th>
                    <th style="padding:10px;border:1px solid #ddd;text-align:right;width:160px;">Harga</th>
                    <th style="padding:10px;border:1px solid #ddd;text-align:right;width:160px;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding:10px;border:1px solid #ddd;">{{ optional($reservasi->paketWisata)->nama_paket ?? 'Paket' }}</td>
                    <td style="padding:10px;border:1px solid #ddd;text-align:center;">{{ $reservasi->jumlah_peserta }} orang</td>
                    <td style="padding:10px;border:1px solid #ddd;text-align:right;">Rp {{ number_format($reservasi->harga,0,',','.') }} /paket</td>
                    <td style="padding:10px;border:1px solid #ddd;text-align:right;">Rp {{ number_format(($reservasi->harga * $reservasi->jumlah_peserta),0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="padding:10px;border:1px solid #ddd;">Diskon (-)</td>
                    <td colspan="2" style="padding:10px;border:1px solid #ddd;text-align:right;">{{ $reservasi->diskon }} %</td>
                    <td style="padding:10px;border:1px solid #ddd;text-align:right;">Rp {{ number_format($reservasi->nilai_diskon ?? 0,0,',','.') }}</td>
                </tr>

                <tr>
                    <td style="padding:10px;border:1px solid #ddd;font-weight:700;">Subtotal</td>
                    <td colspan="2" style="padding:10px;border:1px solid #ddd;"></td>
                    <td style="padding:10px;border:1px solid #ddd;text-align:right;font-weight:700;">Rp {{ number_format(($reservasi->harga * $reservasi->jumlah_peserta),0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="padding:10px;border:1px solid #ddd;font-weight:700;">Total Bayar</td>
                    <td colspan="2" style="padding:10px;border:1px solid #ddd;"></td>
                    <td style="padding:10px;border:1px solid #ddd;text-align:right;font-weight:700;">Rp {{ number_format($reservasi->total_bayar,0,',','.') }}</td>
                </tr>
            </tbody>
        </table>

        <table style="width:100%;margin-top:12px;font-size:13px;">
            <tr>
                <td style="width:40%;vertical-align:top;padding:6px 8px;">
                    <div style="margin-bottom:8px;"><strong>Metode Pembayaran</strong> &nbsp;: {{ $reservasi->file_bukti_tf ? 'TRANSFER' : '-' }}</div>
                    <div style="margin-bottom:8px;"><strong>Status</strong> &nbsp;: {{ ucfirst($reservasi->status_reservasi_wisata) }}</div>
                </td>
                <td style="vertical-align:top;padding:6px 8px;text-align:right;">
                    <div style="margin-top:40px;">Hormat kami,</div>
                    <div style="height:48px;"></div>
                    <div style="font-weight:700;">(Manajemen Desa Wisata)</div>
                </td>
            </tr>
        </table>

        <div style="margin-top:18px;display:flex;justify-content:space-between;gap:12px;">
            <a href="{{ url('/reservasi/riwayat') }}" class="btn btn-outline-secondary">Tutup</a>
            <a href="{{ route('reservasi.invoice.public', $reservasi->id) }}" class="btn btn-primary">Download PDF</a>
        </div>
    </div>
</div>

@endsection
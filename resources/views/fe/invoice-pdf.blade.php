<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $reservasi->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #333;
            font-size: 13px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 28px;
            background: #fff;
        }
        .header {
            text-align: center;
            margin-bottom: 12px;
        }
        .header h2 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
            font-size: 18px;
        }
        .header .subtitle {
            font-size: 14px;
            margin-top: 4px;
            color: #333;
        }
        .header .invoice-no {
            font-weight: 700;
            margin-top: 6px;
            font-size: 13px;
        }
        hr {
            border: none;
            border-top: 2px solid #111;
            margin: 12px 0 18px;
        }
        .info-section {
            width: 100%;
            margin-bottom: 18px;
            font-size: 13px;
        }
        .info-row {
            margin-bottom: 6px;
        }
        .info-row strong {
            display: inline-block;
            width: 180px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .items-table {
            margin-bottom: 12px;
        }
        .items-table thead {
            background: #f5f5f5;
        }
        .items-table th {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-weight: 700;
        }
        .items-table td {
            padding: 10px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        .items-table .text-center {
            text-align: center;
        }
        .items-table .text-right {
            text-align: right;
        }
        .footer-section {
            margin-top: 12px;
            font-size: 13px;
        }
        .footer-row {
            display: flex;
            justify-content: space-between;
        }
        .footer-left {
            width: 40%;
            vertical-align: top;
        }
        .footer-right {
            width: 55%;
            text-align: right;
            padding-top: 40px;
        }
        .signature-block {
            height: 50px;
        }
        .signature-name {
            font-weight: 700;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>DESA WISATA</h2>
            <div class="subtitle">NOTA RESERVASI</div>
            <div class="invoice-no">No: {{ 'NOTA-' . str_pad($reservasi->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>

        <hr>

        <div class="info-section">
            <div class="info-row">
                <strong>Nama Pelanggan</strong> &nbsp;: {{ optional($reservasi->pelanggan)->nama_lengkap ?? '-' }}
            </div>
            <div class="info-row">
                <strong>Tanggal Reservasi</strong> &nbsp;: {{ optional($reservasi->tgl_reservasi_wisata) ? $reservasi->tgl_reservasi_wisata->format('d/m/Y') : '-' }}
            </div>
            @if(isset($reservasi->durasi_hari))
            <div class="info-row">
                <strong>Durasi Liburan</strong> &nbsp;: {{ $reservasi->durasi_hari }} hari
            </div>
            @endif
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Rincian</th>
                    <th style="width:160px;" class="text-center">Jumlah</th>
                    <th style="width:160px;" class="text-right">Harga</th>
                    <th style="width:160px;" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ optional($reservasi->paketWisata)->nama_paket ?? 'Paket' }}</td>
                    <td class="text-center">{{ $reservasi->jumlah_peserta }} orang</td>
                    <td class="text-right">Rp {{ number_format($reservasi->harga,0,',','.') }} /paket</td>
                    <td class="text-right">Rp {{ number_format(($reservasi->harga * $reservasi->jumlah_peserta),0,',','.') }}</td>
                </tr>
                <tr>
                    <td>Diskon (-)</td>
                    <td colspan="2" class="text-right">{{ $reservasi->diskon }} %</td>
                    <td class="text-right">Rp {{ number_format($reservasi->nilai_diskon ?? 0,0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="font-weight:700;">Subtotal</td>
                    <td colspan="2"></td>
                    <td style="text-align:right;font-weight:700;">Rp {{ number_format(($reservasi->harga * $reservasi->jumlah_peserta),0,',','.') }}</td>
                </tr>
                <tr>
                    <td style="font-weight:700;">Total Bayar</td>
                    <td colspan="2"></td>
                    <td style="text-align:right;font-weight:700;">Rp {{ number_format($reservasi->total_bayar,0,',','.') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="footer-section">
            <tr>
                <td class="footer-left">
                    <div style="margin-bottom:8px;"><strong>Metode Pembayaran</strong> &nbsp;: {{ $reservasi->file_bukti_tf ? 'TRANSFER' : '-' }}</div>
                    <div style="margin-bottom:8px;"><strong>Status</strong> &nbsp;: {{ ucfirst($reservasi->status_reservasi_wisata) }}</div>
                </td>
                <td class="footer-right">
                    <div>Hormat kami,</div>
                    <div class="signature-block"></div>
                    <div class="signature-name">(Manajemen Desa Wisata)</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

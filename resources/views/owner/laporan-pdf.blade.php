<h3>Laporan ({{ strtoupper($filter) }})</h3>

<p>Total Pendapatan: Rp {{ number_format((float)$totalPendapatan,0,',','.') }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Paket</th>
        <th>Total</th>
    </tr>

    @foreach($reservasi as $r)
    <tr>
        <td>{{ $r->id }}</td>
        <td>{{ optional($r->pelanggan)->nama_lengkap }}</td>
        <td>{{ optional($r->paketWisata)->nama_paket }}</td>
        <td>Rp {{ number_format((float)$r->total_bayar,0,',','.') }}</td>
    </tr>
    @endforeach
</table>
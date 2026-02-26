<!-- legacy duplicate invoice view kept for compatibility -->

@includeIf('fe.invoice')

{{-- This file is a passthrough to resources/views/fe/invoice.blade.php.
     Keeping a small include avoids 404s from any stale references while
     centralizing the invoice template under `fe`. You can safely delete
     this file later once callers are confirmed to use the `fe` view. --}} 
            <div class="card p-4">
                <h3>Invoice Reservasi Desa Wisata</h3>
                <p><strong>Pelanggan:</strong> {{ optional($reservasi->pelanggan)->nama_lengkap ?? '-' }}</p>
                <p><strong>Paket:</strong> {{ optional($reservasi->paketWisata)->nama_paket ?? '-' }}</p>

                <div class="table-responsive mt-3">
                    <table class="table table-sm mb-0 invoice-table">
                        <tbody>
                            <tr>
                                <td class="label">Harga per Paket</td>
                                <td class="value">Rp {{ number_format($reservasi->harga,0,',','.') }}</td>
                            </tr>
                            <tr>
                                <td class="label">Jumlah Peserta</td>
                                <td class="value">{{ $reservasi->jumlah_peserta }}</td>
                            </tr>
                            <tr>
                                <td class="label">Diskon</td>
                                <td class="value">{{ $reservasi->diskon }} %</td>
                            </tr>
                            <tr>
                                <td class="label fw-bold">Total Bayar</td>
                                <td class="value">Rp {{ number_format($reservasi->total_bayar,0,',','.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ url('/reservasi/riwayat') }}" class="btn btn-outline-secondary">Tutup</a>
                    <a href="{{ route('reservasi.download-invoice', $reservasi->id) }}" class="btn btn-primary">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klaim Voucher</title>
    <link href="{{ asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('fe/assets/css/main.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding-top: 100px;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
        }

        .voucher-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s;
        }

        .voucher-card:hover {
            transform: translateY(-5px);
        }

        .voucher-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .discount-badge {
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .expiry-date {
            color: #7f8c8d;
            font-size: 0.9em;
        }

        .voucher-title {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .voucher-desc {
            color: #7f8c8d;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .claim-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
            transition: background 0.3s;
        }

        .claim-btn:hover {
            background: #2980b9;
        }

        .claimed-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #27ae60;
            color: white;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 0.8em;
        }

        .cashback-badge {
            background: #3498db;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }

        .min-transaksi {
            font-size: 0.9em;
            color: #e74c3c;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <header id="header" class="header d-flex align-items-center fixed-top">
        <nav>@include('fe.navbar')</nav>
    </header>
    <div class="container">
        <h1>Voucher Tersedia</h1>
        <br>

        @forelse($diskons as $diskon)
        <div class="voucher-card">
            @if(auth()->check() && auth()->user()->pelanggan && auth()->user()->pelanggan->hasClaimedVoucher($diskon->id))
            <div class="claimed-badge">Telah Diklaim</div>
            @endif

            <div class="voucher-header">
                <span class="{{ $diskon->jenis_diskon == 'persentase' ? 'discount-badge' : 'cashback-badge' }}">
                    @if($diskon->jenis_diskon == 'persentase')
                    {{ $diskon->nilai_diskon }}% OFF
                    @else
                    Rp {{ number_format($diskon->nilai_diskon) }}
                    @endif
                </span>
                <span class="expiry-date">Berlaku hingga: {{ \Carbon\Carbon::parse($diskon->tanggal_berakhir)->format('d M Y') }}</span>
            </div>
            <div class="voucher-title">{{ $diskon->nama_promo }}</div>
            <div class="voucher-desc">
                {{ $diskon->detail_promo ?? 'Gunakan kode '.$diskon->kode.' saat reservasi' }}
            </div>
            <div class="min-transaksi">
                Minimal transaksi: Rp {{ number_format($diskon->minimal_transaksi) }}
            </div>

            @if(auth()->check() && auth()->user()->pelanggan && auth()->user()->pelanggan->hasClaimedVoucher($diskon->id))
            <button class="claim-btn" disabled style="background: #95a5a6;">Sudah Diklaim</button>
            @else
            <form action="{{ route('diskon.claim', $diskon->id) }}" method="POST" class="claim-form">
                @csrf
                <button type="submit" class="claim-btn">Klaim Voucher</button>
            </form>
            @endif
        </div>
        @empty
        <div class="voucher-card">
            <div class="voucher-title">Tidak ada voucher tersedia saat ini</div>
            <div class="voucher-desc">Silakan cek kembali nanti untuk promo-promo menarik</div>
        </div>
        @endforelse
    </div>

    <script>
        document.querySelectorAll('.claim-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            _token: this.querySelector('input[name="_token"]').value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengklaim voucher');
                    });
            });
        });

        function claimVoucher(id) {
            fetch(`/diskon/claim/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengklaim voucher');
                });
        }
    </script>
</body>

<footer>
    @include('fe.footer')
</footer>

</html>
@php use Illuminate\Support\Facades\Auth; @endphp
<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Menu Utama</li>
            
            {{-- DASHBOARD SESUAI ROLE --}}
            <li>
                <a href="{{ 
                    Auth::user()->level === 'admin' ? route('admin.index') : 
                    (Auth::user()->level === 'bendahara' ? route('bendahara.index') : 
                    route('owner.index')) 
                }}" aria-expanded="false">
                    <i class="bi bi-window-fullscreen"></i>
                    <span class="nav-text">
                        {{ Auth::user()->level === 'admin' ? 'Dashboard Admin' : 
                          (Auth::user()->level === 'bendahara' ? 'Dashboard Bendahara' : 
                          'Dashboard Owner') }}
                    </span>
                </a>
            </li>

            {{-- MENU ADMIN --}}
            @if(Auth::user()->level === 'admin')
                <li class="nav-label">Administrasi</li>
                
                {{-- MANAJEMEN USER --}}
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="bi bi-person-fill-gear"></i>
                        <span class="nav-text">Manajemen Pengguna</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('users.index') }}">Pengguna</a></li>
                        <li><a href="{{ route('karyawan.index') }}">Karyawan</a></li>
                        <li><a href="{{ route('pelanggan.index') }}">Pelanggan</a></li>
                    </ul>
                </li>

                {{-- MANAJEMEN BERITA --}}
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="bi bi-newspaper"></i>
                        <span class="nav-text">Manajemen Berita</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('berita.index') }}">Berita</a></li>
                        <li><a href="{{ route('kategoriberita.index') }}">Kategori Berita</a></li>
                    </ul>
                </li>

            {{-- MENU BENDAHARA --}}
            @elseif(Auth::user()->level === 'bendahara')
                <li class="nav-label">Akomodasi</li>
                <li>
                    <a href="{{ route('penginapan.index') }}" aria-expanded="false">
                        <i class="bi bi-houses"></i>
                        <span class="nav-text">Penginapan</span>
                    </a>
                </li>

                <li class="nav-label">Wisata</li>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="bi bi-card-image"></i>
                        <span class="nav-text">Wisata</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('obyekwisata.index') }}">Objek Wisata</a></li>
                        <li><a href="{{ route('kategoriwisata.index') }}">Kategori Wisata</a></li>
                    </ul>
                </li>

                <li class="nav-label">Paket</li>
                <li>
                    <a href="{{ route('paketwisata.index') }}" aria-expanded="false">
                        <i class="bi bi-card-list"></i>
                        <span class="nav-text">Paket Wisata</span>
                    </a>
                </li>

                <li class="nav-label">Transaksi</li>
                <li>
                    <a href="{{ route('konfirmasireservasi.index') }}" aria-expanded="false">
                        <i class="bi bi-credit-card-2-front-fill"></i>
                        <span class="nav-text">Reservasi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('voucher.index') }}" aria-expanded="false">
                        <i class="bi bi-ticket-detailed"></i>
                        <span class="nav-text">Voucher</span>
                    </a>
                </li>

            {{-- MENU OWNER --}}
            @elseif(Auth::user()->level === 'owner')
                {{-- Hanya dashboard yang muncul --}}
            @endif

        </ul>
    </div>
</div>

@if(config('app.debug'))
<div class="debug-info">
    Peran: {{ Auth::user()->level }} | ID: {{ Auth::id() }} | 
    Login Terakhir: {{ Auth::user()->last_login_at?->format('d/m/Y H:i') ?? 'Belum Pernah' }}
</div>

<style>
    .debug-info {
        position: fixed;
        bottom: 0;
        left: 0;
        background: #333;
        color: #fff;
        padding: 5px 10px;
        font-size: 12px;
        z-index: 9999;
    }
</style>
@endif
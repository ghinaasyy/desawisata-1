<nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="{{ route('home') }}#home" class="nav-link scrollto">Beranda</a></li>
    <li><a href="{{ route('home') }}#wisata" class="nav-link scrollto">Wisata</a></li>
    <li><a href="{{ route('home') }}#paket_wisata" class="nav-link scrollto">Paket Wisata</a></li>
    <li><a href="{{ route('home') }}#penginapan" class="nav-link scrollto">Penginapan</a></li>
    <li><a href="{{ route('home') }}#berita" class="nav-link scrollto">Berita</a></li>
    <li><a href="/reservasi" class="nav-link scrollto">Reservasi</a></li>

    {{-- LOGIN / PROFIL --}}
    @guest
    <li><a href="{{ route('login') }}" class="btn btn-primary text-white">Login</a></li>
    @else
    <li class="dropdown">
      <a href="#">
        <span>{{ auth()->user()->name }}</span>
        <i class="bi bi-chevron-down"></i>
      </a>
      <ul>
        {{-- Profile preview card inside dropdown (vertical) --}}
        <li style="padding:12px 16px; min-width:220px; text-align:left;">
          @php $pel = optional(auth()->user())->pelanggan; @endphp
          <div style="display:flex; flex-direction:column; align-items:center; gap:10px;">
            @if($pel && $pel->foto)
              <img src="{{ asset('storage/' . $pel->foto) }}" alt="avatar" style="width:72px; height:72px; object-fit:cover; border-radius:50%;"> 
            @else
              <div style="width:72px; height:72px; background:#f0f0f0; display:flex;align-items:center;justify-content:center;border-radius:50%;">
                <i class="bi bi-person" style="font-size:28px;color:#000"></i>
              </div>
            @endif
            <div style="width:100%;">
              <div style="font-weight:700; font-size:15px; color:#000; text-align:center;">{{ optional($pel)->nama_lengkap ?? auth()->user()->name }}</div>
              <div style="font-size:13px; color:#000; text-align:center; margin-top:6px;">{{ optional($pel)->no_hp ?? '-' }}</div>
              <div style="font-size:13px; color:#000; text-align:center; margin-top:6px; white-space:normal;">{{ optional($pel)->alamat ?? '-' }}</div>
            </div>
          </div>
        </li>
        <li style="border-top:1px solid rgba(0,0,0,0.06);"></li>
        @if(\Illuminate\Support\Facades\Route::has('pelanggan.profil'))
          <li><a href="{{ route('pelanggan.profil') }}">Profil Saya</a></li>
        @endif
        @if(\Illuminate\Support\Facades\Route::has('pelanggan.riwayat'))
          <li><a href="{{ route('pelanggan.riwayat') }}">Riwayat Pemesanan</a></li>
        @endif
        @if(\Illuminate\Support\Facades\Route::has('reservasi.riwayat'))
          <li><a href="{{ route('reservasi.riwayat') }}">Reservasiku</a></li>
        @endif

        <li>
          <a href="{{ route('logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
          </a>
        </li>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
          @csrf
        </form>
      </ul>
    </li>
    @endguest
  </ul>

  <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
</nav>
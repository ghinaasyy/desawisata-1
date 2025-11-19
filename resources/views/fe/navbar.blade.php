<nav id="navmenu" class="navmenu">
  <ul>
    <li><a href="#home" class="nav-link scrollto">Beranda</a></li>
    <li><a href="#wisata" class="nav-link scrollto">Wisata</a></li>
    <li><a href="#paket_wisata" class="nav-link scrollto">Paket Wisata</a></li>
    <li><a href="#penginapan" class="nav-link scrollto">Penginapan</a></li>
    <li><a href="#berita" class="nav-link scrollto">Berita</a></li>
    <li><a href="#reservasi" class="nav-link scrollto">Reservasi</a></li>

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
        <li><a href="{{ route('pelanggan.profil') }}">Profil Saya</a></li>
        <li><a href="{{ route('pelanggan.riwayat') }}">Riwayat Pemesanan</a></li>

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
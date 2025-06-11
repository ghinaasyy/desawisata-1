@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Desa Arborek Papua</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="fe/assets/img/icon-big.png" rel="icon">
  <link href="fe/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="fe/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="fe/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="fe/assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="fe/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="fe/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="fe/assets/css/main.css" rel="stylesheet">

  <!-- Custom CSS for Profile Dropdown -->
  <style>
    .profile-dropdown {
      position: relative;
      display: inline-block;
    }

    .profile-btn {
      background: none;
      border: 2px solid #fff;
      color: #fff;
      padding: 7px 15px;
      border-radius: 25px;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
      margin-left: 20px;
    }

    .profile-btn:hover {
      background-color: #fff;
      color: #333;
    }

    .profile-dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #fff;
      min-width: 180px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
      border-radius: 8px;
      margin-top: 8px;
    }

    .profile-dropdown-content a {
      color: #333;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid #eee;
    }

    .profile-dropdown-content a:hover {
      background-color: #f5f5f5;
    }

    .profile-dropdown-content a:last-child {
      border-bottom: none;
      color: #dc3545;
    }

    .profile-dropdown:hover .profile-dropdown-content {
      display: block;
    }

    .user-info {
      padding: 12px 16px;
      border-bottom: 2px solid #eee;
      background-color: #f8f9fa;
    }

    .user-info .username {
      font-weight: bold;
      margin-bottom: 4px;
      color: #333;
    }

    .user-info .user-email {
      font-size: 12px;
      color: #666;
    }

    .navbar {
      background-color: #ffffff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      padding: 15px 0;
    }

    .navbar-brand {
      font-weight: 600;
      color: #2c3e50;
    }

    .nav-link {
      color: #34495e !important;
      font-weight: 500;
    }

    .nav-link:hover {
      color: #7795b4 !important;
    }
  </style>
</head>

<header id="header" class="header d-flex align-items-center fixed-top">
  <div class="container-fluid container-xl position-relative d-flex align-items-center">

    <a href="#home" class="logo d-flex align-items-center me-auto">
      <!-- Uncomment the line below if you also wish to use an image logo -->
      <!-- <img src="assets/img/logo.png" alt=""> -->
      <h1 class="sitename">Desa Arborek</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="{{ url('/') }}#home" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ url('/') }}#wisata">Wisata</a></li>
        <li><a href="{{ url('/') }}#paket_wisata">Paket Wisata</a></li>
        <li><a href="{{ url('/') }}#penginapan">Penginapan</a></li>
        <li><a href="{{ url('/') }}#berita">Berita</a></li>
        <li class="dropdown">
          <a href="#"><span>SELENGKAPNYA</span><i class="bi bi-chevron-down toggle-dropdown"></i></a>
          <ul>
            <li><a href="/reservasi" class="{{ request()->is('reservasi') ? 'active' : '' }}">RESERVASI</a></li>
            <li><a href="/diskon" class="{{ request()->is('diskon*') ? 'active' : '' }}">VOUCHER</a></li>
          </ul>
        </li>
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <!-- Authentication Section -->
    @auth
    <!-- Profile dropdown when user is logged in -->
    <div class="profile-dropdown">
      <button class="profile-btn">
        <i class="bi bi-person-circle"></i>
        {{ auth()->user()->name }}
        <i class="bi bi-chevron-down"></i>
      </button>
      <div class="profile-dropdown-content">
        <div class="user-info">
          <div class="username">{{ auth()->user()->name }}</div>
          <div class="user-email">{{ auth()->user()->email }}</div>
        </div>
        <a href="/profile"><i class="bi bi-person me-2"></i>Profile</a>
        @if(auth()->user()->role === 'admin')
        <a href="/admin"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        @elseif(auth()->user()->role === 'bendahara')
        <a href="/bendahara"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        @elseif(auth()->user()->role === 'owner')
        <a href="/owner"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
        @endif
        <a href="/reservasi"><i class="bi bi-calendar-check me-2"></i>My Reservations</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="bi bi-box-arrow-right me-2"></i>Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </div>
    @else
    <!-- Sign In and Sign Up buttons when user is not logged in -->
    <a class="cta-btn" href="/login">Sign In</a>
    <a class="cta-btn" href="/register">Sign Up</a>
    @endauth

  </div>
</header>

</body>

</html>
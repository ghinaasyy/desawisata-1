<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title', 'Desa Wisata')</title>

  <!-- Vendor CSS -->
  <link href="{{ asset('fe/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('fe/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Template Main CSS -->
  <!-- NOTE: stylesheet file in public is named `main.css` not `style.css` -->
  <link href="{{ asset('fe/assets/css/main.css') }}" rel="stylesheet">
  <!-- Page-specific styles -->
  @stack('styles')
</head>

<body>

  {{-- HEADER --}}
  @include('fe.header')

  {{-- NAVBAR is included inside fe.header so we don't include it here --}}

  {{-- MAIN CONTENT --}}
  <main id="main">
    @yield('content')
  </main>

  {{-- FOOTER --}}
  @include('fe.footer')

  <!-- Vendor JS -->
  <script src="{{ asset('fe/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('fe/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Template Main JS -->
  <script src="{{ asset('fe/assets/js/main.js') }}"></script>
  @stack('scripts')
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Panel' }}</title>

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- CSS Libraries -->
    <link href="{{ asset('be/vendor/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('be/vendor/chartist/css/chartist.min.css') }}" rel="stylesheet">

    <!-- Template CSS -->
    <link href="{{ asset('be/css/style.css') }}" rel="stylesheet">

    <!-- Adding CSS MetisMenu -->
    <link href="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Additional CSS -->
    <style>
        /* Preloader styling */
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main content area adjustment */
        .content-body {
            margin-left: 255px;
            padding: 20px;
            min-height: calc(100vh - 80px);
            transition: all 0.3s;
        }

        @media (max-width: 991px) {
            .content-body {
                margin-left: 0;
            }
        }

        /* Fix for footer positioning */
        .footer {
            padding: 15px;
            background: #fff;
            position: relative;
            bottom: 0;
            left: 255px;
            right: 0;
            transition: all 0.3s;
        }

        @media (max-width: 991px) {
            .footer {
                left: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper">

        <!-- Nav header -->
        <div class="nav-header">
            <a href="{{ url('/admin') }}" class="brand-logo">
                <img class="logo-abbr" src="{{ asset('be/images/logo.png') }}" alt="Logo">
                <img class="logo-compact" src="{{ asset('be/images/logo-text.png') }}" alt="Logo Text">
                <img class="brand-title" src="{{ asset('be/images/logo-text.png') }}" alt="Brand Title">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </div>
            </div>
        </div>

        @yield('navbar')
        @yield('sidebar')
        @yield('content')
        @yield('footer')

    </div>

    <!-- Scripts -->
    <script src="{{ asset('be/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('be/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('be/js/custom.min.js') }}"></script>

    <!-- Tambahkan JavaScript MetisMenu -->
    <script src="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.js"></script>

    <!-- Chartist -->
    <script src="{{ asset('be/vendor/chartist/js/chartist.min.js') }}"></script>

    <!-- Calendar -->
    <script src="{{ asset('be/vendor/moment/moment.min.js') }}"></script>
    <script src="{{ asset('be/vendor/pg-calendar/js/pignose.calendar.min.js') }}"></script>

    <!-- Dashboard -->
    <script src="{{ asset('be/js/dashboard/dashboard-2.js') }}"></script>

    <!-- Additional Scripts -->
    <script>
        // Hide preloader when page is loaded
        window.addEventListener('load', function() {
            document.getElementById('preloader').style.display = 'none';
        });

        // Handle sidebar toggle
        document.querySelector('.hamburger').addEventListener('click', function() {
            document.querySelector('.nav-header').classList.toggle('active');
            document.querySelector('.content-body').classList.toggle('active');
            document.querySelector('.footer').classList.toggle('active');
        });
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            title: 'Sukses!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    @endif

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IHARA APPS</title>
    <link rel="shortcut icon" type="x-icon" href="{{ asset('images/logo ihara.png') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url("{{ asset('images/bg.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            /* Ensure the background covers full height */
        }

        #preloader {
            transition: opacity 0.3s ease-in;
        }

        #preloader.hidden {
            opacity: 0;
            /* Buat transparan */
            visibility: hidden;
            /* Hilangkan dari layar */
            pointer-events: none;
            /* Nonaktifkan interaksi */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    {{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
        <div class="container-fluid">
            <!-- Preloader -->
            <div id="preloader" class="d-flex justify-content-center align-items-center" 
            style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(255, 0, 0, 0); z-index: 1050;">
            <div>
            <div class="spinner-border text-info" role="status" style="width: 3rem; height: 3rem;">
            </div>
            </div>
            </div>

            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo ihara.png') }}" alt="Dashboard" width="70" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('absen.tampil') }}">Data Karyawan</a>
                    </li> --}}
    {{-- <li class="nav-item">
                        <a class="nav-link" href="#">Absensi</a>
                    </li> --}}
    {{-- </ul> --}}
    <!-- Menu di sebelah kanan -->
    {{-- <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @if (Auth::check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->nama }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profil.tampil') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav> --}}

    <!-- Alert Section -->
    <div class="container mt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Content Section -->
    <div class="container mt-4">
        @yield('konten')
    </div>

    @include('layouts.bottomNav2')



    @include('layouts.script')

    <!-- jQuery, Bootstrap JS, SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fungsi untuk menyembunyikan preloader
        function hidePreloader() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('hidden'); // Tambahkan class 'hidden'
                // Opsional: Hapus elemen dari DOM setelah animasi selesai
                setTimeout(() => preloader.remove(), 300);
            }
        }

        // Tunggu hingga halaman selesai dimuat
        window.addEventListener('load', () => {
            setTimeout(hidePreloader, 300); // 1 detik setelah load
        });
    </script>


</body>

</html>

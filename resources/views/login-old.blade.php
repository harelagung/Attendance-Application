<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link rel="shortcut icon" type="x-icon" href="{{ asset('images/logo ihara.png') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        body {
            background: url("{{ asset('images/bg.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            height: 100dvh;
            /* Ensure the background covers full height */
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <!-- Main Container for Centered Content -->
    <div class="container d-flex flex-column align-items-center justify-content-center vh-100">
        <!-- Logo -->
        <img src="{{ asset('images/logo ihara.png') }}" width="170" height="80" class="mb-4">

        <!-- Prompt Text -->


        <!-- Login Form Card -->
        <div class="col-10 col-sm-8 col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="mb-5 mt-3 text-center" style="font-weight:600">Masukkan ID dan Password</p>
                    <form action="{{ route('login.attempt') }}" method="POST">
                        @csrf
                        <!-- ID Karyawan Field -->
                        <div class="mb-3">
                            <label for="id_karyawan" class="form-label">ID Karyawan</label>
                            <input type="text" inputmode="numeric" name="id_karyawan" id="id_karyawan"
                                class="form-control" placeholder="Masukkan ID Karyawan" autocomplete="off" required>
                        </div>

                        <!-- Password Field with Toggle (No Border) -->
                        <div class="mb-3">
                            <label for="password1" class="form-label">Password</label>
                            <div class="position-relative">
                                <input type="password" name="password" class="form-control pe-5" id="password1"
                                    maxlength="8" placeholder="Masukkan Password" required>
                                <div class="position-absolute top-50 end-0 translate-middle-y pe-3"
                                    style="cursor: pointer;" onclick="lihatPassword('password1')">
                                    <ion-icon name="eye-outline" id="passwordIcon"></ion-icon>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button class="btn btn-primary w-100" type="submit">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 for Error Notification -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <!-- Script for Password Toggle -->
    <script>
        function lihatPassword(id) {
            var x = document.getElementById(id);
            var icon = document.getElementById('passwordIcon');

            if (x.type === "password") {
                x.type = "text";
                icon.setAttribute('name', 'eye-off-outline');
            } else {
                x.type = "password";
                icon.setAttribute('name', 'eye-outline');
            }
        }
    </script>
</body>

</html>

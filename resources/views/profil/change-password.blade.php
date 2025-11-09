<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IHARA APPS</title>
    <link rel="shortcut icon" type="x-icon" href="{{ asset('images/logo ihara.png') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.css') }}">
    <!-- Font Awesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .navbar .container {
            position: relative;
        }

        .center-title {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            margin: 0;
            font-weight: bold;
            color: white;
        }
    </style>
</head>

<body>

    <!-- Navbar Biru -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('profil.tampil') }}" style="cursor: pointer;">
                <ion-icon name="chevron-back"></ion-icon>
            </a>
            <span class="center-title">Perbarui Password</span>
        </div>
    </nav>


    <form id="passwordForm" action="{{ route('profil.update-password') }}" method="POST"
        onsubmit="return cekPassword();">
        @csrf
        <center>
            <div class="container bg-white mt-5 p-4 shadow" style="width: 350px; border-radius: 15px;">
                <div class="mb-3">
                    <label for="password1" class="form-label">Masukkan Password Baru</label>
                    <div class="position-relative">
                        <input type="password" name="new_password" class="form-control pe-5" id="password1"
                            maxlength="8" placeholder="Masukkan 8 karakter" required>
                        <div class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor: pointer;"
                            onclick="lihatPassword('password1')">
                            <ion-icon name="eye" id="passwordIcon1"></ion-icon>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password1" class="form-label">Konfirmasi Password</label>
                    <div class="position-relative">
                        <input type="password" name="confirm_password" class="form-control pe-5" id="password2"
                            maxlength="8" placeholder="Masukkan password yang sama" required>
                        <div class="position-absolute top-50 end-0 translate-middle-y pe-3" style="cursor: pointer;"
                            onclick="lihatPassword('password2')">
                            <ion-icon name="eye" id="passwordIcon2"></ion-icon>
                        </div>
                    </div>
                </div>

                <!-- Tempat pesan kesalahan -->
                <div id="pesanError" style="color: red; display: none;">Password tidak cocok</div>

                <button type="submit" class="btn btn-primary mt-4 mb-3">Perbarui Password</button>
            </div>
        </center>
    </form>

    <script>
        // Fungsi untuk melihat/mengubah jenis input password
        function lihatPassword(id) {
            var input = document.getElementById(id);
            var iconId = 'passwordIcon' + id.replace('password', '');
            var icon = document.getElementById(iconId);

            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute('name', 'eye-off');
            } else {
                input.type = "password";
                icon.setAttribute('name', 'eye');
            }
        }

        function cekPassword() {
            // Mengambil nilai dari kedua input password
            var password1 = document.getElementById('password1').value;
            var password2 = document.getElementById('password2').value;

            // Cek panjang password (kondisi baru)
            if (password1.length < 8) {
                document.getElementById('pesanError').innerHTML = "Password kurang dari 8 karakter";
                document.getElementById('pesanError').style.display = "block";
                return false; // Mencegah form dikirim
            }
            // Jika password tidak sama, tampilkan pesan error
            else if (password1 !== password2) {
                document.getElementById('pesanError').innerHTML = "Password tidak sama";
                document.getElementById('pesanError').style.display = "block";
                return false; // Mencegah form dikirim
            } else {
                document.getElementById('pesanError').style.display = "none";

                // Tampilkan SweetAlert dan lanjutkan submit form
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Password berhasil diperbarui',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form secara manual setelah SweetAlert ditutup
                        document.getElementById('passwordForm').submit();
                    }
                });

                return false; // Mencegah form dikirim secara otomatis
            }
        }

        function handleBack() {
            // Logika untuk kembali
            window.history.back();
        }
    </script>

    @include('layouts.script')

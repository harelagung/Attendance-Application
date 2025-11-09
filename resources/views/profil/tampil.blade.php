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
            <a class="navbar-brand" href="/dashboard" style="cursor: pointer;">
                <ion-icon name="chevron-back"></ion-icon>
            </a>
            <span class="center-title">Profil Pribadi</span>
        </div>
    </nav>
    <!-- Konten Utama -->
    <div class="container mt-2">

        <div class="container mt-4">
            <div class="card">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <tr>
                                    <th width="150">ID Karyawan</th>
                                    <td>: {{ Auth::user()->id_karyawan }}</td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>: {{ Auth::user()->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Kelamin</th>
                                    <td>: {{ Auth::user()->jenkel }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: {{ Auth::user()->alamat }}</td>
                                </tr>
                                <tr>
                                    <th>No. HP</th>
                                    <td>: {{ Auth::user()->no_hp }}</td>
                                </tr>
                                <tr>
                                    <th>Department</th>
                                    <td>: {{ Auth::user()->department }}</td>
                                </tr>
                                <tr>
                                    <th>Jabatan</th>
                                    <td>: {{ Auth::user()->jabatan }}</td>
                                </tr>
                                <tr>
                                    <th>Status Perkawinan</th>
                                    <td>: {{ Auth::user()->status_perkawinan }}</td>
                                </tr>
                                <tr>
                                    <th>Status Pekerja</th>
                                    <td>: {{ Auth::user()->status_pekerja }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Join</th>
                                    <td>: {{ Auth::user()->join }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Berakhir</th>
                                    <td>: {{ Auth::user()->end }}</td>
                                </tr>
                                <tr>
                                    <th style="border: 0ch"><br><a href="{{ route('profil.change-password') }}"
                                            class="btn btn-warning">Ganti Password</a></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    {{-- <h5 class="card-title">Profil Pribadi</h5> --}}

                    <div class="ms-auto">

                    </div>

                </div>
            </div>
        </div>


        @include('layouts.script')

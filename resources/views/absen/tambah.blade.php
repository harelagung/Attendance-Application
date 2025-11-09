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
            <a class="navbar-brand" href="{{ route('absen.tampil') }}" style="cursor: pointer;">
                <ion-icon name="chevron-back"></ion-icon>
            </a>
            <span class="center-title" style="font-size: 1.2rem">Tambah Data</span>
        </div>
    </nav>


<div class="px-3">

<form action="{{ route('absen.submit') }}" method="POST" class="mt-2" enctype="multipart/form-data">
    @csrf
    <label class="mb-2" style="font-weight: 700">Upload Foto Karyawan</label>
    <div class="custom-file-upload" id="fileUpload1">
        <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
        <input type="hidden" name="image" id="imageBase64">
        <label for="fileuploadInput">
            <span>
                <strong>
                    <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                </strong>
            </span>
        </label>
    </div>
    <label class="mt-2" style="font-weight: 700">ID Karyawan</label>
    <input type="number" name="id_karyawan" maxlength="8" class="form-control mb-2" placeholder="Masukkan Nomor ID" required>
    <label style="font-weight: 700">Nama Lengkap</label>
    <input type="text" name="nama" class="form-control mb-2" style="text-transform:capitalize;" placeholder="Masukkan Nama Lengkap">
    <label style="font-weight: 700">Jenis Kelamin</label>
    <select name="jenkel" class="form-control mb-2">
        <option value="Laki-Laki">Laki-Laki</option>
        <option value="Perempuan">Perempuan</option>
    </select>
    <label style="font-weight: 700">Alamat</label>
    <input type="text" name="alamat" class="form-control mb-2" placeholder="Masukkan Alamat Lengkap">
    <label style="font-weight: 700">No Kontak</label>
    <input type="number" name="no_hp" class="form-control mb-2" placeholder="Masukkan Nomor Kontak">
    <label style="font-weight: 700">Department</label>
    <select name="department" id="department" class="form-control mb-2" onchange="updateJabatan()">
        <option value="Casting">Casting</option>
        <option value="Engineering">Engineering</option>
        <option value="Finance">Finance</option>
        <option value="HR">HR</option>
        <option value="Machining">Machining</option>
        <option value="Painting">Painting</option>
        <option value="Production Control">Production Control</option>
        <option value="Quality Control">Quality Control</option>
    </select>
    <label style="font-weight: 700">Jabatan</label>
    <select name="jabatan" id="jabatan" class="form-control mb-2">
        <option value="Staff">Staff</option>
        <option value="Operator">Operator</option>
        <option value="Leader">Leader</option>
        <option value="Foreman">Foreman</option>
        <option value="Supervisor">Supervisor</option>
        <option value="Assistant Manager">Assistant Manager</option>
        <option value="Manager">Manager</option>
    </select>
    <label style="font-weight: 700">Status Perkawinan</label>
    <select name="status_perkawinan" class="form-control mb-2">
        <option value="Lajang">Lajang</option>
        <option value="Menikah">Menikah</option>
        <option value="Bercerai">Bercerai</option>
    </select>
    <label style="font-weight: 700">Status Pekerja</label>
    <select name="status_pekerja" class="form-control mb-2">
        <option value="Tetap">Tetap</option>
        <option value="Kontrak">Kontrak</option>
    </select>
    <label style="font-weight: 700">Join Date</label>
    <input type="date" name="join" class="form-control mb-2">
    <label style="font-weight: 700">Akhir Masa Kerja</label>
    <input type="date" name="end" class="form-control mb-2">
<br>
    <button class="btn btn-primary mb-5">Tambah Data</button>
    <br><br>
</form>
</div>


<script>
function updateJabatan() {
    var department = document.getElementById('department').value;
    var jabatanSelect = document.getElementById('jabatan');
    
    // Hapus option "Admin" jika ada
    var adminOption = null;
    for (var i = 0; i < jabatanSelect.options.length; i++) {
        if (jabatanSelect.options[i].value === "Admin") {
            adminOption = jabatanSelect.options[i];
            jabatanSelect.remove(i);
            break;
        }
    }
    
    // Tambahkan option "Admin" jika department adalah HR
    if (department === "HR") {
        var option = document.createElement("option");
        option.text = "Admin";
        option.value = "Admin";
        jabatanSelect.add(option, 0); // Tambahkan di posisi pertama
    }
}

// Jalankan saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateJabatan();
});

function handleBack() {
    // Logika untuk kembali
    window.history.back();
    }

document.addEventListener('DOMContentLoaded', function() {
    const fileUpload = document.getElementById('fileuploadInput');
    const imageBase64Input = document.getElementById('imageBase64');
    
    fileUpload.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Set base64 data ke input hidden
                imageBase64Input.value = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});

</script>

@include('layouts.script')
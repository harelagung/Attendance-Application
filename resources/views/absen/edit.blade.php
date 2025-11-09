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
            <span class="center-title" style="font-size: 1.2rem">Edit Data</span>
        </div>
    </nav>


<div class="px-3">
<form action="{{ route('absen.update', $karyawan->id_karyawan) }}" method="POST" class="mt-2" enctype="multipart/form-data">
    @csrf
    <label class="mb-2" style="font-weight: 700">Upload Foto Karyawan</label>
    <div class="custom-file-upload" id="fileUpload1">
        <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
        <label for="fileuploadInput">
            <span>
                <strong>
                    <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                </strong>
            </span>
        </label>
    </div>
    <label style="font-weight: 700">ID Karyawan</label>
    <input type="number" name="id_karyawan" value="{{ $karyawan->id_karyawan }}" class="form-control mb-2" maxlength="8" required>
    <label style="font-weight: 700">Nama Lengkap</label>
    <input type="text" name="nama" value="{{ $karyawan->nama }}" class="form-control mb-2" style="text-transform:capitalize;">
    <label style="font-weight: 700">Jenis Kelamin</label>
    <select name="jenkel" class="form-control mb-2">
        <option value="Laki-Laki" @selected($karyawan->jenkel == 'Laki-Laki')>Laki-Laki</option>
        <option value="Perempuan" @selected($karyawan->jenkel == 'Perempuan')>Perempuan</option>
    </select>
    <label style="font-weight: 700">Alamat</label>
    <input type="text" name="alamat" value="{{ $karyawan->alamat }}" class="form-control mb-2">
    <label style="font-weight: 700">No Kontak</label>
    <input type="number" name="no_hp" value="{{ $karyawan->no_hp }}" class="form-control mb-2">
    <label style="font-weight: 700">Department</label>

    <select name="department" id="department" class="form-control mb-2" onchange="updateJabatan()">
        <option value="Casting" @selected($karyawan->department == 'Casting')>Casting</option>
        <option value="Engineering" @selected($karyawan->department == 'Engineering')>Engineering</option>
        <option value="Finance" @selected($karyawan->department == 'Finance')>Finance</option>
        <option value="HR" @selected($karyawan->department == 'HR')>HR</option>
        <option value="Machining" @selected($karyawan->department == 'Machining')>Machining</option>
        <option value="Painting" @selected($karyawan->department == 'Painting')>Painting</option>
        <option value="Production Control" @selected($karyawan->department == 'Production Control')>Production Control</option>
        <option value="Quality Control" @selected($karyawan->department == 'Quality Control')>Quality Control</option>
    </select>
    <label style="font-weight: 700">Jabatan</label>
    <select name="jabatan" id="jabatan" class="form-control mb-2">
    @if($karyawan->department == 'HR')
        <option value="Admin" @selected($karyawan->jabatan == 'Admin')>Admin</option>
    @endif
    <option value="Staff" @selected($karyawan->jabatan == 'Staff')>Staff</option>
    <option value="Operator" @selected($karyawan->jabatan == 'Operator')>Operator</option>
    <option value="Leader" @selected($karyawan->jabatan == 'Leader')>Leader</option>
    <option value="Foreman" @selected($karyawan->jabatan == 'Foreman')>Foreman</option>
    <option value="Supervisor" @selected($karyawan->jabatan == 'Supervisor')>Supervisor</option>
    <option value="Assistant Manager" @selected($karyawan->jabatan == 'Assistant Manager')>Assistant Manager</option>
    <option value="Manager" @selected($karyawan->jabatan == 'Manager')>Manager</option>
</select>
    <label style="font-weight: 700">Status Perkawinan</label>
    <select name="status_perkawinan" class="form-control mb-2">
        <option value="Lajang" @selected($karyawan->status_perkawinan == 'Lajang')>Lajang</option>
        <option value="Menikah" @selected($karyawan->status_perkawinan == 'Menikah')>Menikah</option>
        <option value="Bercerai" @selected($karyawan->status_perkawinan == 'Bercerai')>Bercerai</option>
    </select>
    <label style="font-weight: 700">Status Pekerja</label>
    <select name="status_pekerja" class="form-control mb-2">
        <option value="Tetap" @selected($karyawan->status_pekerja == 'Tetap')>Tetap</option>
        <option value="Kontrak" @selected($karyawan->status_pekerja == 'Kontrak')>Kontrak</option>
    </select>
    <label style="font-weight: 700">Join Date</label>
    <input type="date" name="join" value="{{ $karyawan->join }}" class="form-control mb-2">
    <label style="font-weight: 700">Akhir Masa Kerja</label>
    <input type="date" name="end" value="{{ $karyawan->end }}" class="form-control mb-2">
    
<br>
    <button class="btn btn-primary mb-5">Perbarui Data</button>
    <br><br>
</form>

</div>

@include('layouts.script')

<script>
    function updateJabatan() {
    var department = document.getElementById('department').value;
    var jabatanSelect = document.getElementById('jabatan');
    var currentValue = jabatanSelect.value; // Simpan nilai saat ini
    
    // Cek apakah opsi Admin sudah ada
    var adminExists = false;
    for (var i = 0; i < jabatanSelect.options.length; i++) {
        if (jabatanSelect.options[i].value === "Admin") {
            adminExists = true;
            // Jika department bukan HR, hapus opsi Admin
            if (department !== "HR") {
                jabatanSelect.remove(i);
            }
            break;
        }
    }
    
    // Tambahkan option "Admin" jika department adalah HR dan belum ada
    if (department === "HR" && !adminExists) {
        var option = document.createElement("option");
        option.text = "Admin";
        option.value = "Admin";
        jabatanSelect.add(option, 0);
    }
    
    // Kembalikan nilai sebelumnya jika masih valid
    if (currentValue === "Admin" && department === "HR") {
        jabatanSelect.value = "Admin";
    }
}

// Jalankan saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateJabatan();
});
</script>
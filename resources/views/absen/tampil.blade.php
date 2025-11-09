@extends('layouts.admin.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle"></div>
                    <h2 class="page-title" style="font-size: 1.7rem">Data Karyawan</h2>
                </div>
                <div class="col-auto ms-auto">
                    <a href="{{ route('absen.tambah') }}" class="btn btn-primary d-none d-sm-inline-block"
                        data-bs-toggle="modal" data-bs-target="#modal-report">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Tambah Data Karyawan
                    </a>
                    <a href="{{ route('absen.tambah') }}" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                        data-bs-target="#modal-report" aria-label="Tambah Data Karyawan">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="row">
            <div class="col">
                @php
                    $messagesuccess = Session::get('success');
                    $messageerror = Session::get('error');
                @endphp
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {{ $messagesuccess }}
                    </div>
                @endif
                @if (Session::get('error'))
                    <div class="alert alert-danger">
                        {{ $messageerror }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal untuk tambah data karyawan -->
        <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Data Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form tambah data karyawan -->
                        <form id="formTambahKaryawan" action="{{ route('absen.submit') }}" method="POST" class="mt-2"
                            enctype="multipart/form-data">
                            @csrf
                            <label class="mb-2" style="font-weight: 700">Upload Foto Karyawan</label>
                            <div class="custom-file-upload" id="fileUpload1">
                                <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                                <input type="hidden" name="image" id="imageBase64">
                                <label for="fileuploadInput">
                                    <span>
                                        <strong>
                                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                                aria-label="cloud upload outline"></ion-icon>
                                        </strong>
                                    </span>
                                </label>
                            </div>
                            <label class="mt-2" style="font-weight: 700">ID Karyawan</label>
                            <input type="number" name="id_karyawan" maxlength="8" class="form-control mb-2"
                                placeholder="Masukkan Nomor ID" required>
                            <label style="font-weight: 700">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control mb-2"
                                style="text-transform:capitalize;" placeholder="Masukkan Nama Lengkap" autocomplete="off">
                            <label style="font-weight: 700">Jenis Kelamin</label>
                            <select name="jenkel" class="form-control mb-2">
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <label style="font-weight: 700">Alamat</label>
                            <input type="text" name="alamat" class="form-control mb-2"
                                placeholder="Masukkan Alamat Lengkap" autocomplete="off">
                            <label style="font-weight: 700">No Kontak</label>
                            <input type="number" name="no_hp" class="form-control mb-2"
                                placeholder="Masukkan Nomor Kontak" autocomplete="off">
                            <label style="font-weight: 700">Department</label>
                            <select name="department" id="department" class="form-control mb-2"
                                onchange="updateJabatan()">
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
                                <option value="Admin" id="optAdmin" style="display:none">Admin</option>
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
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                            Batal
                        </a>
                        <button type="submit" form="formTambahKaryawan" class="btn btn-primary ms-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Simpan Data
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal untuk edit data karyawan -->
        <div class="modal modal-blur fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data Karyawan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form edit data karyawan -->
                        <form id="formEditKaryawan" method="POST" class="mt-2" enctype="multipart/form-data">
                            @csrf
                            <label class="mb-2" style="font-weight: 700">Upload Foto Karyawan</label>
                            <div class="custom-file-upload" id="fileUpload1">
                                <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
                                <label for="fileuploadInput">
                                    <span>
                                        <strong>
                                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated"
                                                aria-label="cloud upload outline"></ion-icon>
                                        </strong>
                                    </span>
                                </label>
                            </div>
                            <label style="font-weight: 700">ID Karyawan</label>
                            <input type="number" name="id_karyawan" id="edit_id_karyawan" class="form-control mb-2"
                                maxlength="8" autocomplete="off" required>
                            <label style="font-weight: 700">Nama Lengkap</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control mb-2"
                                style="text-transform:capitalize;" autocomplete="off">
                            <label style="font-weight: 700">Jenis Kelamin</label>
                            <select name="jenkel" id="edit_jenkel" class="form-control mb-2">
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <label style="font-weight: 700">Alamat</label>
                            <input type="text" name="alamat" id="edit_alamat" class="form-control mb-2"
                                autocomplete="off">
                            <label style="font-weight: 700">No Kontak</label>
                            <input type="number" name="no_hp" id="edit_no_hp" class="form-control mb-2"
                                autocomplete="off">
                            <label style="font-weight: 700">Department</label>

                            <select name="department" id="edit_department" class="form-control mb-2"
                                onchange="updateEditJabatan()">
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
                            <select name="jabatan" id="edit_jabatan" class="form-control mb-2">
                                <option value="Admin" id="optAdmin" style="display:none">Admin</option>
                                <option value="Staff">Staff</option>
                                <option value="Operator">Operator</option>
                                <option value="Leader">Leader</option>
                                <option value="Foreman">Foreman</option>
                                <option value="Supervisor">Supervisor</option>
                                <option value="Assistant Manager">Assistant Manager</option>
                                <option value="Manager">Manager</option>
                            </select>
                            <label style="font-weight: 700">Status Perkawinan</label>
                            <select name="status_perkawinan" id="edit_status_perkawinan" class="form-control mb-2">
                                <option value="Lajang">Lajang</option>
                                <option value="Menikah">Menikah</option>
                                <option value="Bercerai">Bercerai</option>
                            </select>
                            <label style="font-weight: 700">Status Pekerja</label>
                            <select name="status_pekerja" id="edit_status_pekerja" class="form-control mb-2">
                                <option value="Tetap">Tetap</option>
                                <option value="Kontrak">Kontrak</option>
                            </select>
                            <label style="font-weight: 700">Join Date</label>
                            <input type="date" name="join" id="edit_join" class="form-control mb-2">
                            <label style="font-weight: 700">Akhir Masa Kerja</label>
                            <input type="date" name="end" id="edit_end" class="form-control mb-2">

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Konten Utama -->
        <div class="container mt-2">
            <!-- Tabel Responsive -->
            <div class="table-responsive">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('absen.tampil') }}" method="GET">
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <div class="form-group">
                                        <input type="text" name="keyword" id="keyword" class="form-control"
                                            placeholder="Cari Data Karyawan" value="{{ Request('keyword') }}">
                                    </div>
                                </div>
                                <div class="col-md-3 d-none d-md-block">
                                    <div class="form-group">
                                        <select name="department" id="kode_dept" class="form-select">
                                            <option value="">Department</option>
                                            @foreach ($department as $d)
                                                <option value="{{ $d->department }}"
                                                    {{ request('department') == $d->department ? 'selected' : '' }}>
                                                    {{ $d->department }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1 col-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                <path d="M21 21l-6 -6" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr style="text-align: center">
                                            <th style="align-content: center">No</th>
                                            <th style="align-content: center">ID</th>
                                            <th style="align-content: center">Nama</th>
                                            <th class="d-none d-md-table-cell" style="align-content: center">Department
                                            </th>
                                            <th class="d-none d-md-table-cell" style="align-content: center">Jenis Kelamin
                                            </th>
                                            <th class="d-none d-md-table-cell" style="align-content: center">Jabatan</th>
                                            <th class="d-none d-md-table-cell" style="align-content: center">Status <br>
                                                Perkawinan</th>
                                            <th class="d-none d-md-table-cell" style="align-content: center">Status
                                                Pekerja</th>
                                            <th class="d-none d-md-table-cell" style="align-content: center">Join Date
                                            </th>
                                            <th class="d-none d-md-table-cell" style="align-content: center">Akhir Masa
                                                Kerja</th>
                                            <th style="align-content: center">Tindakan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($karyawan as $no => $data)
                                            <tr>
                                                <td style="align-content: center;text-align:center">
                                                    {{ $no + 1 + $karyawan->firstItem() - 1 }}</td>
                                                <td style="align-content: center;text-align:center">
                                                    {{ $data->id_karyawan }}</td>
                                                <td style="align-content: center;text-align:center">{{ $data->nama }}
                                                </td>
                                                <td class="d-none d-md-table-cell"
                                                    style="align-content: center;text-align:center">
                                                    {{ $data->department }}</td>
                                                <td class="d-none d-md-table-cell"
                                                    style="align-content: center;text-align:center">{{ $data->jenkel }}
                                                </td>
                                                <td class="d-none d-md-table-cell"
                                                    style="align-content: center;text-align:center">{{ $data->jabatan }}
                                                </td>
                                                <td class="d-none d-md-table-cell"
                                                    style="align-content: center;text-align:center">
                                                    {{ $data->status_perkawinan }}</td>
                                                <td class="d-none d-md-table-cell"
                                                    style="align-content: center;text-align:center">
                                                    {{ $data->status_pekerja }}</td>
                                                <td class="d-none d-md-table-cell"
                                                    style="align-content: center;text-align:center">{{ $data->join }}
                                                </td>
                                                <td class="d-none d-md-table-cell"
                                                    style="align-content: center;text-align:center">{{ $data->end }}
                                                </td>
                                                <td>
                                                    <!-- Untuk tampilan desktop dan mobile -->
                                                    <div>
                                                        <button class="btn btn-primary btn-sm"
                                                            onclick="showActionModal({{ json_encode($data) }})">
                                                            Aksi <i class="fas fa-chevron-down ms-1"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Form untuk hapus tetap ada tapi disembunyikan -->
                                                    <form action="{{ route('absen.delete', $data->id_karyawan) }}"
                                                        method="POST" id="deleteForm{{ $data->id_karyawan }}"
                                                        style="display:none;">
                                                        @csrf
                                                    </form>
                                                    <!-- Form untuk reset password -->
                                                    <form id="resetPasswordForm{{ $data->id_karyawan }}"
                                                        action="{{ route('reset-password', $data->id_karyawan) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Detail -->
            <div class="modal modal-blur fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel">Detail Karyawan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <!-- Detail karyawan dengan tata letak yang lebih estetik -->
                            <div class="container-fluid p-0">
                                <!-- Foto karyawan di bagian atas -->
                                <div class="text-center mb-4">
                                    <div class="position-relative d-inline-block">
                                        <img id="detailFoto" onerror="this.src='/storage/upload/avatar1.jpg';"
                                            src="/storage/upload/avatar1.jpg" alt="Foto Karyawan"
                                            class="rounded-circle img-thumbnail"
                                            style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #007bff;">
                                    </div>
                                </div>
                                <!-- Informasi karyawan dengan styling yang lebih baik -->
                                <div class="card shadow-sm border-0 mb-3">
                                    <div class="card-body p-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-group mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-id-badge text-primary me-2"></i>
                                                        <h6 class="mb-0 fw-bold">Informasi Dasar</h6>
                                                    </div>
                                                    <div class="list-group list-group-flush border-start ps-3"
                                                        style="border-left: 3px solid #007bff;">
                                                        <div class="list-group-item border-0 px-0 py-2">
                                                            <div class="row">
                                                                <div class="col-5 text-muted">ID Karyawan</div>
                                                                <div class="col-7 fw-medium" id="detailID"></div>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item border-0 px-0 py-2">
                                                            <div class="row">
                                                                <div class="col-5 text-muted">Nama</div>
                                                                <div class="col-7 fw-medium" id="detailNama"></div>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item border-0 px-0 py-2">
                                                            <div class="row">
                                                                <div class="col-5 text-muted">Jenis Kelamin</div>
                                                                <div class="col-7 fw-medium" id="detailJenkel"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="info-group mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-user-tie text-success me-2"></i>
                                                        <h6 class="mb-0 fw-bold">Status Personal</h6>
                                                    </div>
                                                    <div class="list-group list-group-flush border-start ps-3"
                                                        style="border-left: 3px solid #28a745;">
                                                        <div class="list-group-item border-0 px-0 py-2">
                                                            <div class="row">
                                                                <div class="col-5 text-muted">Status Perkawinan</div>
                                                                <div class="col-7 fw-medium" id="detailStatusPerkawinan">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="info-group mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-briefcase text-warning me-2"></i>
                                                        <h6 class="mb-0 fw-bold">Informasi Pekerjaan</h6>
                                                    </div>
                                                    <div class="list-group list-group-flush border-start ps-3"
                                                        style="border-left: 3px solid #ffc107;">
                                                        <div class="list-group-item border-0 px-0 py-2">
                                                            <div class="row">
                                                                <div class="col-5 text-muted">Department</div>
                                                                <div class="col-7 fw-medium" id="detailDepartment"></div>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item border-0 px-0 py-2">
                                                            <div class="row">
                                                                <div class="col-5 text-muted">Jabatan</div>
                                                                <div class="col-7 fw-medium" id="detailJabatan"></div>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item border-0 px-0 py-2">
                                                            <div class="row">
                                                                <div class="col-5 text-muted">Status Pekerja</div>
                                                                <div class="col-7 fw-medium" id="detailStatusPekerja">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="info-group mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-calendar-alt text-danger me-2"></i>
                                                        <h6 class="mb-0 fw-bold">Periode Kerja</h6>
                                                    </div>
                                                    <div class="list-group list-group-flush border-start ps-3"
                                                        style="border-left: 3px solid #dc3545;">
                                                        <div class="list-group-item border-0 px-0 py-2">
                                                            <div class="row">
                                                                <div class="col-5 text-muted">Join Date</div>
                                                                <div class="col-7 fw-medium" id="detailJoin"></div>
                                                            </div>
                                                        </div>
                                                        <div class="list-group-item border-0 px-0 py-2">
                                                            <div class="row">
                                                                <div class="col-5 text-muted">Akhir Masa Kerja</div>
                                                                <div class="col-7 fw-medium" id="detailEnd"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Aksi -->
            <div class="modal modal-blur fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="actionModalLabel">Aksi untuk <span id="actionModalName"></span>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-success mb-2" onclick="handleReview()">
                                    <ion-icon name="eye"></ion-icon>&nbsp;Review
                                </button>
                                <button class="btn btn-primary mb-2" onclick="handleEdit()">
                                    <ion-icon name="create"></ion-icon>&nbsp;Edit
                                </button>
                                <button class="btn btn-warning mb-2" onclick="handleResetPassword()">
                                    <ion-icon name="key"></ion-icon>&nbsp;Reset Password
                                </button>
                                <button class="btn btn-danger mb-2" onclick="handleDelete()">
                                    <ion-icon name="trash"></ion-icon>&nbsp;Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col mt-3">
                    <div class="d-flex justify-content-center">
                        {{ $karyawan->links('vendor.pagination.simple-bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('myscript')
        <!-- Script -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        timer: 3000,
                        showConfirmButton: false
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: "{{ session('error') }}",
                        timer: 3000,
                        showConfirmButton: false
                    });
                });
            </script>
        @endif
        <script>
            // Memunculkan Admin untuk Dpt. HR
            function updateJabatan() {
                const dept = document.getElementById('department').value;
                const adminOpt = document.getElementById('optAdmin');

                if (dept === 'HR') {
                    adminOpt.style.display = ''; // tampilkan
                } else {
                    // sembunyikan, dan jika ter‐select, ubah ke Staff agar tidak ter‐submit “Admin”
                    adminOpt.style.display = 'none';
                    if (document.getElementById('jabatan').value === 'Admin') {
                        document.getElementById('jabatan').value = 'Staff';
                    }
                }
            }

            // panggil sekali saat page load,
            document.addEventListener('DOMContentLoaded', updateJabatan);

            // Variabel untuk data karyawan yang sedang aktif
            let currentEmployeeData = null;

            // Fungsi untuk menampilkan detail modal review
            function showDetailModal(data) {
                document.getElementById('detailID').textContent = data.id_karyawan;
                document.getElementById('detailNama').textContent = data.nama;
                document.getElementById('detailJenkel').textContent = data.jenkel;
                document.getElementById('detailDepartment').textContent = data.department;
                document.getElementById('detailJabatan').textContent = data.jabatan;
                document.getElementById('detailStatusPerkawinan').textContent = data.status_perkawinan;
                document.getElementById('detailStatusPekerja').textContent = data.status_pekerja;
                document.getElementById('detailJoin').textContent = data.join;
                document.getElementById('detailEnd').textContent = data.end;

                // Set foto dengan pengecekan yang benar

                document.getElementById('detailFoto').src = '/storage/upload/foto_karyawan/' + data.foto;


                var detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
                detailModal.show();
            }

            // Tampilkan modal aksi dengan data karyawan
            function showActionModal(data) {
                currentEmployeeData = data;
                document.getElementById('actionModalName').textContent = data.nama;

                var actionModal = new bootstrap.Modal(document.getElementById('actionModal'));
                actionModal.show();
            }

            // Handler untuk aksi review
            function handleReview() {
                // Sembunyikan action modal
                bootstrap.Modal.getInstance(document.getElementById('actionModal')).hide();
                // Tampilkan detail modal
                setTimeout(function() {
                    showDetailModal(currentEmployeeData);
                }, 400); // Delay sedikit agar modal pertama selesai menutup
            }

            // Handler untuk aksi edit
            // Handler untuk aksi edit
            function handleEdit() {
                // Gunakan data karyawan yang sudah disimpan di currentEmployeeData
                editKaryawan(
                    currentEmployeeData.id_karyawan,
                    currentEmployeeData.nama,
                    currentEmployeeData.jenkel,
                    currentEmployeeData.alamat,
                    currentEmployeeData.no_hp,
                    currentEmployeeData.department,
                    currentEmployeeData.jabatan,
                    currentEmployeeData.status_perkawinan,
                    currentEmployeeData.status_pekerja,
                    currentEmployeeData.join,
                    currentEmployeeData.end
                );

                // Tutup modal aksi
                var actionModal = bootstrap.Modal.getInstance(document.getElementById('actionModal'));
                actionModal.hide();
            }

            function editKaryawan(id_karyawan, nama, jenkel, alamat, no_hp, department, jabatan, status_perkawinan,
                status_pekerja, join, end) {
                // Set action URL
                document.getElementById('formEditKaryawan').action = "{{ url('absen/update') }}/" + id_karyawan;

                // Isi data ke form
                document.getElementById('edit_id_karyawan').value = id_karyawan;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_jenkel').value = jenkel;
                document.getElementById('edit_alamat').value = alamat;
                document.getElementById('edit_no_hp').value = no_hp;
                document.getElementById('edit_department').value = department;
                document.getElementById('edit_jabatan').value = jabatan;
                document.getElementById('edit_status_perkawinan').value = status_perkawinan;
                document.getElementById('edit_status_pekerja').value = status_pekerja;
                document.getElementById('edit_join').value = join;
                document.getElementById('edit_end').value = end;

                // Tampilkan modal edit
                var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            }

            // Fungsi untuk update pilihan jabatan berdasarkan department untuk form edit
            function updateEditJabatan() {
                var department = document.getElementById('edit_department').value;
                var jabatanSelect = document.getElementById('edit_jabatan');

                // Reset options
                jabatanSelect.innerHTML = '';

                // Add default options
                var defaultOptions = ['Staff', 'Operator', 'Leader', 'Foreman', 'Supervisor', 'Assistant Manager', 'Manager'];

                // Add Admin option only for HR department
                if (department === 'HR') {
                    var adminOption = document.createElement('option');
                    adminOption.value = 'Admin';
                    adminOption.text = 'Admin';
                    jabatanSelect.add(adminOption);
                }

                // Add the default options
                defaultOptions.forEach(function(option) {
                    var newOption = document.createElement('option');
                    newOption.value = option;
                    newOption.text = option;
                    jabatanSelect.add(newOption);
                });
            }

            // Handler untuk aksi hapus
            function handleDelete() {
                // Sembunyikan action modal
                bootstrap.Modal.getInstance(document.getElementById('actionModal')).hide();
                // Tampilkan konfirmasi hapus
                setTimeout(function() {
                    confirmDelete(currentEmployeeData.nama, currentEmployeeData.id_karyawan);
                }, 400); // Delay sedikit agar modal pertama selesai menutup
            }

            // Konfirmasi delete dengan SweetAlert
            function confirmDelete(nama, id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: `Anda akan menghapus data ${nama}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`deleteForm${id}`).submit();
                    }
                });
            }

            // Handler untuk aksi reset password
            function handleResetPassword() {
                // Sembunyikan action modal
                bootstrap.Modal.getInstance(document.getElementById('actionModal')).hide();
                // Tampilkan konfirmasi reset password
                setTimeout(function() {
                    confirmResetPassword(currentEmployeeData.nama, currentEmployeeData.id_karyawan);
                }, 400); // Delay sedikit agar modal pertama selesai menutup
            }

            // Konfirmasi reset password dengan SweetAlert
            function confirmResetPassword(nama, id) {
                Swal.fire({
                    title: 'Reset Password?',
                    text: `Anda akan mereset password untuk ${nama}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Reset',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit form untuk reset password
                        document.getElementById(`resetPasswordForm${id}`).submit();
                    }
                });
            }

            // Fungsi untuk kembali
            function handleBack() {
                window.history.back();
            }

            const allEmployeeData = @json($karyawan);
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

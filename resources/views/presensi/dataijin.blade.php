@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle"></div>
                    <h2 class="page-title" style="font-size: 1.7rem">Data Pengajuan Ijin Karyawan</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            {{-- Kolom Pencarian --}}
            <div class="row">
                <div class="col-12">
                    <form action="/presensi/dataijin" method="get" autocomplete="off">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                            <path d="M16 3l0 4" />
                                            <path d="M8 3l0 4" />
                                            <path d="M4 11l16 0" />
                                            <path d="M8 15h2v2h-2z" />
                                        </svg>
                                    </span>
                                    <input class="form-control" value="{{ Request('dari') }}" id="dari" type="text"
                                        name="dari" placeholder="Parameter Awal Tanggal Ijin" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-event">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M4 5m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                                            <path d="M16 3l0 4" />
                                            <path d="M8 3l0 4" />
                                            <path d="M4 11l16 0" />
                                            <path d="M8 15h2v2h-2z" />
                                        </svg>
                                    </span>
                                    <input class="form-control" value="{{ Request('sampai') }}" id="sampai"
                                        type="text" name="sampai" placeholder="Parameter Akhir Tanggal Ijin"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-barcode">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                                            <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                                            <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                                            <path d="M16 20h2a2 2 0 0 0 2 -2v-1" />
                                            <path d="M5 11h1v2h-1z" />
                                            <path d="M10 11l0 2" />
                                            <path d="M14 11h1v2h-1z" />
                                            <path d="M19 11l0 2" />
                                        </svg>
                                    </span>
                                    <input class="form-control" value="{{ Request('id_karyawan') }}" id="id_karyawan"
                                        type="text" name="id_karyawan" placeholder="NIK" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                            <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                        </svg>
                                    </span>
                                    <input class="form-control" value="{{ Request('nama') }}" id="nama" type="text"
                                        name="nama" placeholder="Nama Karyawan" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <select name="status_approved" id="status_approved" class="form-select">
                                        <option value="">
                                            Pilih Status</option>
                                        <option value="0" {{ Request('status_approved') === '0' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="1" {{ Request('status_approved') == 1 ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="2" {{ Request('status_approved') == 2 ? 'selected' : '' }}>Di
                                            Tolak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <button class="btn btn-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                            <path d="M21 21l-6 -6" />
                                        </svg>
                                        Cari Data
                                    </button>
                                    <a href="/presensi/dataijin" class="btn btn-danger ms-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                            <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                        </svg>
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Kolom Data --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="text-align: center">
                                        <th style="align-content: center">No.</th>
                                        <th style="align-content: center">NIK</th>
                                        <th style="align-content: center">Nama Karyawan</th>
                                        <th style="align-content: center">Department</th>
                                        <th style="align-content: center">Tgl Pengajuan <br> Formulir</th>
                                        <th style="align-content: center">Tgl Ijin</th>
                                        <th style="align-content: center">Jam Mulai <br> Ijin</th>
                                        <th style="align-content: center">Jam Selesai <br> Ijin</th>
                                        <th style="align-content: center">Alasan</th>
                                        <th style="align-content: center">Status</th>
                                        <th style="align-content: center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ijin as $no => $d)
                                        <tr>
                                            <td style="align-content: center;text-align:center">
                                                {{ $no + 1 + $ijin->firstItem() - 1 }}
                                            </td>
                                            <td style="align-content: center;text-align:center">
                                                {{ $d->id_karyawan }}
                                            </td>
                                            <td style="align-content: center;text-align:center">
                                                {{ $d->nama }}
                                            </td>
                                            <td style="align-content: center;text-align:center">
                                                {{ $d->department }}
                                            </td>
                                            <td style="align-content: center;text-align:center">
                                                {{ $d->tgl_formulir }}
                                            </td>
                                            <td style="align-content: center;text-align:center">
                                                {{ $d->tgl_ijin }}
                                            </td>
                                            <td style="align-content: center;text-align:center">
                                                {{ $d->jam_mulai }}
                                            </td>
                                            <td style="align-content: center;text-align:center">
                                                {{ $d->jam_selesai }}
                                            </td>
                                            <td style="align-content: center">
                                                {{ $d->alasan_ijin }} <br> - <br> {{ $d->keterangan }}
                                            </td>
                                            <td style="align-content: center;text-align:center">
                                                @if ($d->status_approved == 0)
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif ($d->status_approved == 1)
                                                    <span class="badge bg-success">Approved</span>
                                                @else
                                                    <span class="badge bg-danger">Di Tolak</span>
                                                @endif
                                            </td>
                                            <td style="align-content: center;text-align:center">
                                                @if ($d->status_approved == 0)
                                                    <a href="#" class="btn btn-md btn-primary btn-aksi"
                                                        style="text-align: center"
                                                        data-id-formulir="{{ $d->id_formulir }}"
                                                        data-bukti="{{ $d->bukti }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-external-link">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                                            <path d="M11 13l9 -9" />
                                                            <path d="M15 4h5v5" />
                                                        </svg>
                                                    </a>
                                                @else
                                                    <a href="/presensi/{{ $d->id_formulir }}/batalstatus"
                                                        class="btn btn-md bg-danger">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M18 6l-12 12" />
                                                            <path d="M6 6l12 12" />
                                                        </svg>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col mt-3">
                                    <div class="d-flex justify-content-center">
                                        {{ $ijin->links('vendor.pagination.simple-bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Aksi -->
        <div class="modal modal-blur fade" id="modal-ijin" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Status Ijin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Tambahkan area untuk menampilkan bukti foto -->
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <h3>Bukti Ijin</h3>
                                <div id="bukti-container">
                                    <img id="img-bukti" src="" class="img-fluid" alt="Bukti Ijin"
                                        style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                        <form action="/presensi/approvedijin" method="POST">
                            @csrf
                            <input type="hidden" name="id_ijin_formulir" id="id_ijin_formulir">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <select name="status_approved" id="status_approved" class="form-select"
                                            onchange="handleStatusChange(this)">
                                            <option value="1">Approved</option>
                                            <option value="2">Tolak</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3" id="alasan_penolakan_group" style="display: none;">
                                        <label for="alasan_penolakan" class="form-label mt-4">Alasan Penolakan</label>
                                        <input type="text" name="alasan_penolakan" id="alasan_penolakan"
                                            autocomplete="off" class="form-control"
                                            placeholder="Masukkan alasan penolakan...">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary w-100" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 14l11 -11" />
                                                <path
                                                    d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                                            </svg>
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <script>
        // Fungsi global untuk handle perubahan status approval
        function handleStatusChange(selectElement) {
            const statusValue = selectElement.value;
            // Ambil element dari modal untuk memastikan tidak konflik dengan form filter
            const alasanGroup = document.querySelector('#modal-ijin #alasan_penolakan_group');
            const alasanInput = document.querySelector('#modal-ijin #alasan_penolakan');

            console.log('Status changed to:', statusValue);

            if (statusValue === '2') {
                // Tampilkan input alasan penolakan
                if (alasanGroup) {
                    alasanGroup.style.display = 'block';
                }
                if (alasanInput) {
                    alasanInput.required = true;
                }
                console.log('Menampilkan input alasan penolakan');
            } else {
                // Sembunyikan input alasan penolakan
                if (alasanGroup) {
                    alasanGroup.style.display = 'none';
                }
                if (alasanInput) {
                    alasanInput.required = false;
                    alasanInput.value = '';
                }
                console.log('Menyembunyikan input alasan penolakan');
            }
        }

        // Fungsi validasi form yang diperbaiki
        function validateForm() {
            // Ambil element dari modal, bukan dari form filter
            const statusApproved = document.querySelector('#modal-ijin select[name="status_approved"]');
            const alasanPenolakan = document.querySelector('#modal-ijin input[name="alasan_penolakan"]');

            // Cek apakah element ada
            if (!statusApproved) {
                console.error('Element status_approved di modal tidak ditemukan');
                return false;
            }

            const statusValue = statusApproved.value;
            console.log('Status approved value:', statusValue);

            // Jika belum memilih status
            if (statusValue === '' || statusValue === null || statusValue === undefined) {
                alert('Silakan pilih status approval!');
                statusApproved.focus();
                return false;
            }

            // Jika status adalah tolak tapi alasan kosong
            if (statusValue === '2') {
                if (!alasanPenolakan) {
                    console.error('Element alasan_penolakan tidak ditemukan');
                    return false;
                }

                if (alasanPenolakan.value.trim() === '') {
                    alert('Silakan masukkan alasan penolakan!');
                    alasanPenolakan.focus();
                    return false;
                }
            }

            return true;
        }

        $(function() {
            // Validasi form sebelum submit - hanya untuk form di modal
            $('#modal-ijin form').on('submit', function(e) {
                console.log('Modal form submit triggered');

                // Prevent default submission first
                e.preventDefault();

                // Validate form
                if (!validateForm()) {
                    console.log('Validation failed');
                    return false;
                }

                console.log('Validation passed, submitting form...');

                // If validation passes, submit the form programmatically
                this.submit();
            });

            // Inisialisasi datepicker untuk tanggal harian
            $("#dari ,#sampai").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
                orientation: 'bottom auto',
                container: 'body'
            });

            // Event saat tanggal dipilih
            $("#tanggal").on('changeDate', function(e) {
                var tanggal = $(this).val();
                loadDataHarian(tanggal);
            });

            // Modal Aksi
            $(".btn-aksi").click(function(e) {
                e.preventDefault();
                const id_formulir = $(this).data('idFormulir');
                const bukti = $(this).data('bukti');
                $("#id_ijin_formulir").val(id_formulir);


                // Tampilkan bukti jika ada
                if (bukti && bukti !== '') {
                    // Path ke file bukti
                    var buktiPath = "/storage/upload/bukti/" + bukti;
                    console.log("Path bukti:", buktiPath);

                    // Tampilkan gambar
                    $("#bukti-container").html('<img src="' + buktiPath +
                        '" class="img-fluid" alt="Bukti Ijin" style="max-height: 200px; cursor: pointer;">'
                    );

                    // Tambahkan event listener untuk gambar yang baru dibuat
                    $("#bukti-container img").click(function() {
                        openFullscreen(this);
                    });
                } else {
                    // Jika tidak ada bukti
                    $("#bukti-container").html('<div class="alert alert-info">Tidak ada bukti foto</div>');
                }

                $("#modal-ijin").modal("show");
            });

            // Fungsi untuk membuka gambar dalam mode fullscreen
            function openFullscreen(img) {
                if (img.requestFullscreen) {
                    img.requestFullscreen();
                } else if (img.webkitRequestFullscreen) {
                    /* Safari */
                    img.webkitRequestFullscreen();
                } else if (img.msRequestFullscreen) {
                    /* IE11 */
                    img.msRequestFullscreen();
                }
            }
        });
    </script>
@endpush

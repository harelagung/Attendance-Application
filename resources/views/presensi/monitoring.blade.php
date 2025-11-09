@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle"></div>
                    <h2 class="page-title" style="font-size: 1.7rem">Monitoring Presensi</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Tambahkan toggle buttons -->
                            <div class="row mb-3">
                                <div class="col-md-6 col-12 mb-3">
                                    <div class="btn-group" role="group">
                                        <input type="radio" class="btn-check" name="tampilan_mode" id="btnHarian"
                                            autocomplete="off"
                                            {{ request('tampilan_mode', 'harian') === 'harian' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="btnHarian">Tampilan Harian</label>

                                        <input type="radio" class="btn-check" name="tampilan_mode" id="btnBulanan"
                                            autocomplete="off"
                                            {{ request('tampilan_mode') === 'bulanan' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary" for="btnBulanan">Tampilan Bulanan</label>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <form action="" id="cari">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" name="cari" class="form-control"
                                                placeholder="Cari Data Presensi">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="bi bi-search"></i>
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
                                    </form>
                                </div>
                            </div>


                            <!-- Input tanggal (sudah ada) -->
                            <div class="row filter-harian mb-3">
                                <div class="col">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                <path d="M16 3v4" />
                                                <path d="M8 3v4" />
                                                <path d="M4 11h16" />
                                                <path d="M7 14h.013" />
                                                <path d="M10.01 14h.005" />
                                                <path d="M13.01 14h.005" />
                                                <path d="M16.015 14h.005" />
                                                <path d="M13.015 17h.005" />
                                                <path d="M7.01 17h.005" />
                                                <path d="M10.01 17h.005" />
                                            </svg>
                                        </span>
                                        <input type="text" value="" class="form-control"
                                            placeholder="Masukkan Tanggal Presensi" autocomplete="off" id="tanggal"
                                            name="tanggal">
                                    </div>
                                </div>
                            </div>

                            <!-- Tambahkan input bulan (baru) -->
                            <div class="row filter-bulanan mb-3" style="display:none;">
                                <div class="col">
                                    <div class="input-icon mb-3">
                                        <span class="input-icon-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-month">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
                                                <path d="M16 3v4" />
                                                <path d="M8 3v4" />
                                                <path d="M4 11h16" />
                                                <path d="M8 14h.01" />
                                                <path d="M12 14h.01" />
                                                <path d="M16 14h.01" />
                                                <path d="M8 17h.01" />
                                                <path d="M12 17h.01" />
                                                <path d="M16 17h.01" />
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Pilih Bulan"
                                            autocomplete="off" id="bulan" name="bulan" value="{{ date('Y-m') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Id</th>
                                                <th>Nama</th>
                                                <th>Department</th>
                                                <th>Shift</th>
                                                <!-- Tambahkan kolom tanggal untuk tampilan bulanan -->
                                                <th class="kolom-tanggal" style="display:none;">Tanggal</th>
                                                <th>Jam Masuk</th>
                                                <th>Foto</th>
                                                <th>Jam Pulang</th>
                                                <th>Foto</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="loadpresensi"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
        let form = document.getElementById('cari');
        let searchInput = form.querySelector('input[name="cari"]');

        searchInput.addEventListener('input', function(e) {
            e.preventDefault();
            const keyword = this.value;

            // Cek apakah tampilan harian atau bulanan yang aktif
            const isHarian = $("#btnHarian").is(":checked");
            const filterType = isHarian ? 'harian' : 'bulanan';

            // Ambil nilai tanggal atau bulan berdasarkan tampilan yang aktif
            let params = new URLSearchParams();
            params.append('cari', keyword);
            params.append('filter_type', filterType);

            if (isHarian) {
                const tanggal = $("#tanggal").val() || moment().format('YYYY-MM-DD');
                params.append('tanggal', tanggal);
            } else {
                const bulan = $("#bulan").val() || moment().format('YYYY-MM');
                params.append('bulan', bulan);
            }

            let url = `/cari?${params.toString()}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    updateTable(data);
                })
                .catch(error => console.error('Error:', error));
        });

        function selisih(jam_standar, jam_masuk) {
            // Konversi string waktu ke objek Date
            const [h1, m1, s1] = jam_standar.split(':').map(Number);
            const [h2, m2, s2] = jam_masuk.split(':').map(Number);

            // Hitung waktu dalam menit
            const menit1 = h1 * 60 + m1;
            const menit2 = h2 * 60 + m2;

            // Hitung selisih dalam menit
            const selisihMenit = menit2 - menit1;

            // Konversi ke jam dan menit
            const jam = Math.floor(selisihMenit / 60);
            const menit = Math.round(selisihMenit % 60);

            return jam + " jam " + menit + " menit";
        }

        function updateTable(data) {
            const tableBody = document.querySelector('table tbody');
            if (!tableBody) return;

            // Cek mode tampilan (harian/bulanan)
            const isBulanan = $("#btnBulanan").is(":checked");

            let html = '';

            if (data.length === 0) {
                const colSpan = isBulanan ? 11 : 10;
                html = `<tr><td colspan="${colSpan}" class="text-center">Data tidak ditemukan</td></tr>`;
            } else {
                data.forEach((item, index) => {
                    const foto_in = `/storage/upload/absensi/${item.foto_in}`;
                    const foto_out = item.foto_out ? `/storage/upload/absensi/${item.foto_out}` : '';

                    // Status keterlambatan
                    let statusTerlambat = '';
                    if ((item.shift == 1 && item.jam_in > '07:00:00') || (item.shift == 2 && item.jam_in >
                            '19:00:00')) {
                        // Tentukan jam standar berdasarkan shift
                        const jam_standar = (item.shift == 1) ? '07:00:00' : '19:00:00';
                        const jamterlambat = selisih(jam_standar, item.jam_in);
                        statusTerlambat =
                            `<span class="badge badge bg-danger">Terlambat <br> ${jamterlambat}</span>`;
                    } else {
                        statusTerlambat = '<span class="badge badge bg-success">Ok</span>';
                    }

                    // Format tanggal dari tgl_presensi (YYYY-MM-DD) ke format yang lebih mudah dibaca (DD-MM-YYYY)
                    const tanggalPresensi = item.tgl_presensi ? formatDate(item.tgl_presensi) : '';

                    html += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.id_karyawan}</td>
                <td>${item.nama || ''}</td>
                <td>${item.department || ''}</td>
                <td>${item.shift}</td>
                <td class="kolom-tanggal" ${!isBulanan ? 'style="display:none;"' : ''}>${tanggalPresensi}</td>
                <td>${item.jam_in}</td>
                <td>
                    <img src="${foto_in}" class="avatar" alt=""
                    onerror="this.src='/assets/img/sample/avatar/avatar1.jpg'">
                </td>
                <td>${item.jam_out != null ? item.jam_out : '<span class="badge bg-danger">Belum Absen Pulang</span>'}</td>
                <td>
                    ${item.jam_out != null ? 
                        `<img src="${foto_out}" class="avatar" alt="">` : 
                        `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-hourglass-high"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6.5 7h11" /><path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" /><path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" /></svg>`
                    }
                </td>
                <td>${statusTerlambat}</td>
            </tr>
            `;
                });
            }

            tableBody.innerHTML = html;
        }

        // Fungsi helper untuk memformat tanggal
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        // Mencegah form submit normal
        form.addEventListener('submit', function(e) {
            e.preventDefault();
        });

        $(function() {
            // Inisialisasi datepicker untuk tanggal harian
            $("#tanggal").datepicker({
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

            // Inisialisasi datepicker untuk bulan
            $('#bulan')
                .datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    format: 'yyyy-mm',
                    startView: 1,
                    minViewMode: 1,
                    orientation: 'bottom auto',
                    container: 'body'
                })
                .on('changeDate change', function() {
                    const bulan = $(this).val();
                    console.log('Memilih bulan:', bulan);
                    loadDataBulanan(bulan);
                });

            // Toggle antara tampilan harian dan bulanan
            $("#btnHarian").change(function() {
                if ($(this).is(":checked")) {
                    $(".filter-harian").show();
                    $(".filter-bulanan").hide();
                    $(".kolom-tanggal").hide();

                    // Reset tampilan atau load data default
                    var tanggal = $("#tanggal").val() || "{{ date('Y-m-d') }}";
                    if (tanggal) {
                        loadDataHarian(tanggal);
                    } else {
                        $("#loadpresensi").html(
                            '<tr><td colspan="9" class="text-center">Silahkan pilih tanggal</td></tr>');
                    }
                }
            });

            $("#btnBulanan").change(function() {
                if ($(this).is(":checked")) {
                    $(".filter-harian").hide();
                    $(".filter-bulanan").show();
                    $(".kolom-tanggal").show();

                    // Reset tampilan atau load data default
                    var bulan = $("#bulan").val() || "{{ date('Y-m') }}";
                    if (bulan) {
                        loadDataBulanan(bulan);
                    } else {
                        $("#loadpresensi").html(
                            '<tr><td colspan="10" class="text-center">Silahkan pilih bulan</td></tr>');
                    }
                }
            });

            // Fungsi untuk load data harian (sudah ada)
            function loadDataHarian(tanggal) {
                $.ajax({
                    type: 'POST',
                    url: '/getpresensi',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            }

            // Fungsi untuk load data bulanan (baru)
            function loadDataBulanan(bulan) {
                $.ajax({
                    type: 'POST',
                    url: '/getpresensibulanan',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan
                    },
                    cache: false,
                    success: function(respond) {
                        $("#loadpresensi").html(respond);
                    }
                });
            }

            // Load default data saat halaman dibuka (tampilan harian)
            var defaultTanggal = "{{ date('Y-m-d') }}";
            loadDataHarian(defaultTanggal);
            $("#tanggal").val(defaultTanggal);
        });
    </script>
@endpush

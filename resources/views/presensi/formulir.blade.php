@extends('layouts.presensiform')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:history.back()" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Formulir Pengajuan</div>
        <div class="right"></div>
    </div>
@endsection
@section('content')
    <div class="row" style="margin-top: 60px">
        <div class="col" style="margin-left: 10px;margin-right: 10px">
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::get('warning'))
                <div class="alert alert-warning">
                    {{ Session::get('warning') }}
                </div>
            @endif
            <div class="presencetab mt-1">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-cuti" role="tab"
                                style="font-weight: 700">
                                Cuti
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-ijin" role="tab" style="font-weight: 700">
                                Ijin
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <!-- Tab Cuti -->
                    <div class="tab-pane fade show active" id="tab-cuti" role="tabpanel">
                        <div class="px-3">
                            <form action="/presensi/storeformulir" method="POST" id="form-cuti"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="status" value="Cuti">

                                <label style="font-weight: 700">Jenis Cuti</label>
                                <select name="jenis_cuti" id="jenis_cuti" class="form-control mb-2" required>
                                    <option value="">-- Pilih Jenis Cuti --</option>
                                    <option value="Cuti Tahunan">Cuti Tahunan</option>
                                    <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                    <option value="Cuti Menikah">Cuti Menikah</option>
                                    <option value="Cuti Menikahkan Anak">Cuti Menikahkan Anak</option>
                                    <option value="Cuti Anak Sunat / Baptis">Cuti Anak Sunat / Baptis</option>
                                    <option value="Cuti Istri Melahirkan">Cuti Istri Melahirkan</option>
                                    <option value="Cuti Keluarga Meninggal">Cuti Keluarga Meninggal</option>
                                    <option value="Cuti Panggilan Negara">Cuti Panggilan Negara</option>
                                    <option value="Cuti Haji / Umroh">Cuti Haji / Umroh</option>
                                </select>

                                <label class="mt-2" style="font-weight: 700">Tanggal Mulai Cuti</label>
                                <input type="date" name="tgl_mulai" id="tgl_mulai_cuti" class="form-control mb-2"
                                    required>

                                <div id="tgl_selesai_container">
                                    <label class="mt-2" style="font-weight: 700">Tanggal Selesai Cuti</label>
                                    <input type="date" name="tgl_selesai" id="tgl_selesai_cuti" class="form-control mb-2"
                                        required>
                                </div>

                                <label class="mt-2" style="font-weight: 700">Lama Cuti (Hari)</label>
                                <input type="text" name="lama_cuti" id="lama_cuti" class="form-control mb-2" readonly>

                                <label style="font-weight: 700">Keterangan</label>
                                <textarea name="keterangan" id="keterangan_cuti" class="form-control mb-2" style="min-height: 100px; resize: vertical;"
                                    placeholder="Masukkan Keterangan Lengkap" required></textarea>

                                <label style="font-weight: 700">Lampiran Foto (Jika Ada)</label>
                                <input type="file" name="bukti" id="bukti_cuti" class="form-control mb-2">

                                <button type="submit" class="btn btn-primary w-100 mt-2">
                                    <ion-icon name="paper-plane"></ion-icon> Ajukan Cuti
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Tab Ijin -->
                    <div class="tab-pane fade" id="tab-ijin" role="tabpanel">
                        <div class="px-3">
                            <form action="/presensi/storeformulir" method="POST" id="form-ijin"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="status" value="Ijin">
                                <label class="mt-2" style="font-weight: 700">Tanggal Ijin</label>
                                <input type="date" name="tgl_ijin" id="tgl_ijin" class="form-control mb-2" required>

                                <div class="form-group">
                                    <label style="font-weight: 700">Jam Mulai <small class="text-muted">(Format 24
                                            Jam)</small></label>
                                    <div class="input-group">
                                        <select name="jam_mulai_hour" id="jam_mulai_hour" class="form-control" required>
                                            <option value="">Jam</option>
                                            @for ($i = 0; $i < 24; $i++)
                                                <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <span class="input-group-text">:</span>
                                        <select name="jam_mulai_minute" id="jam_mulai_minute" class="form-control"
                                            required>
                                            <option value="">Menit</option>
                                            @for ($i = 0; $i < 60; $i++)
                                                <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <input type="hidden" name="jam_mulai" id="jam_mulai_hidden">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label style="font-weight: 700">Jam Selesai <small class="text-muted">(Format 24
                                            Jam)</small></label>
                                    <div class="input-group">
                                        <select name="jam_selesai_hour" id="jam_selesai_hour" class="form-control"
                                            required>
                                            <option value="">Jam</option>
                                            @for ($i = 0; $i < 24; $i++)
                                                <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <span class="input-group-text">:</span>
                                        <select name="jam_selesai_minute" id="jam_selesai_minute" class="form-control"
                                            required>
                                            <option value="">Menit</option>
                                            @for ($i = 0; $i < 60; $i++)
                                                <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}
                                                </option>
                                            @endfor
                                        </select>
                                        <input type="hidden" name="jam_selesai" id="jam_selesai_hidden">
                                    </div>
                                </div>

                                <label style="font-weight: 700">Alasan Ijin</label>
                                <select name="alasan_ijin" id="alasan_ijin" class="form-control mb-2" required>
                                    <option value="">-- Pilih Alasan --</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Urusan Keluarga">Urusan Keluarga</option>
                                    <option value="Dinas Luar">Dinas Luar</option>
                                    <option value="Pulang Cepat">Pulang Cepat</option>
                                    <option value="Datang Terlambat">Datang Terlambat</option>
                                </select>

                                <label style="font-weight: 700">Keterangan</label>
                                <textarea name="keterangan" id="keterangan_ijin" class="form-control mb-2"
                                    style="min-height: 100px; resize: vertical;" placeholder="Masukkan Keterangan Lengkap" required></textarea>

                                <label style="font-weight: 700">Lampiran Foto (Jika Ada)</label>
                                <input type="file" name="bukti" id="bukti_ijin" class="form-control mb-2">

                                <button type="submit" class="btn btn-primary w-100 mt-2">
                                    <ion-icon name="paper-plane"></ion-icon> Ajukan Ijin
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal untuk menampilkan bukti foto -->
    <div class="modal fade" id="modalBukti" tabindex="-1" role="dialog" aria-labelledby="modalBuktiLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBuktiLabel">Bukti Lampiran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="bukti-image" src="" class="img-fluid" alt="Bukti Lampiran">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        // Fungsi handleBack
        function handleBack() {
            window.location.href = '/dashboard';
        }

        // JS: ubah format ke YYYY-MM-DD sebelum AJAX
        function toISO(dateStr) {
            const d = new Date(dateStr);
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            return `${d.getFullYear()}-${mm}-${dd}`;
        }



        $(document).ready(function() {
            // Fungsi untuk menampilkan bukti foto dalam modal
            $('.lihat-bukti').on('click', function(e) {
                e.preventDefault();
                const imageUrl = $(this).data('foto');
                $('#bukti-image').attr('src', imageUrl);
                $('#modalBukti').modal('show');
            });

            $('#tgl_ijin').change(function(e) {
                var tgl_ijin = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: '/presensi/cekpengajuanijin',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tgl_ijin: tgl_ijin
                    },
                    cache: false,
                    success: function(respond) {
                        if (respond >= 2) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Tidak boleh mengajukan ijin di tanggal yang sama!'
                            }).then((result) => {
                                $('#tgl_ijin').val("");
                            });
                        }
                    }
                })
            });

            $('#tgl_mulai_cuti').change(function() {
                const raw = $(this).val(); // e.g. "05/23/2025"
                const tgl = toISO(raw); // "2025-05-23"

                $.ajax({
                    type: 'POST',
                    url: '/presensi/cekpengajuancuti',
                    dataType: 'json', // <- penting biar jQuery parse jadi JS object
                    data: {
                        _token: "{{ csrf_token() }}",
                        tgl_mulai: tgl
                    },
                    success(res) {
                        // res.count sekarang integer 0 atau >0
                        if (res.count !== 0) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Tidak boleh mengajukan cuti di tanggal yang sama!'
                            }).then(() => $('#tgl_mulai_cuti').val(''));
                        }
                    },
                    error(xhr) {
                        console.error('AJAX error:', xhr);
                    }
                });
            });



            // Durasi cuti tetap per jenis (sesuaikan angka hari jika perlu)
            const cutiTetap = {
                "Cuti Melahirkan": 90,
                "Cuti Menikah": 3,
                "Cuti Menikahkan Anak": 2,
                "Cuti Anak Sunat / Baptis": 2,
                "Cuti Istri Melahirkan": 2,
                "Cuti Keluarga Meninggal": 3,
                "Cuti Panggilan Negara": 10,
                "Cuti Haji / Umroh": 30
            };

            // Hitung tanggal selesai hanya hari kerja (Mon–Fri)
            function hitungTanggalSelesaiKerja(tglMulai, lamaCuti) {
                let count = 0;
                const date = new Date(tglMulai);
                // loop hingga terhitung lamaCuti hari kerja
                while (count < lamaCuti) {
                    const day = date.getDay(); // 0=Sun,6=Sat
                    if (day !== 0 && day !== 6) {
                        count++;
                    }
                    if (count < lamaCuti) {
                        date.setDate(date.getDate() + 1);
                    }
                }
                const yyyy = date.getFullYear();
                const mm = String(date.getMonth() + 1).padStart(2, '0');
                const dd = String(date.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`;
            }

            // Hitung selisih hari kerja antara dua tanggal (inklusif)
            function hitungSelisihHariKerja(tglMulai, tglSelesai) {
                const start = new Date(tglMulai),
                    end = new Date(tglSelesai);
                let count = 0;
                const oneDay = 24 * 60 * 60 * 1000;
                for (let d = start; d <= end; d = new Date(d.getTime() + oneDay)) {
                    const w = d.getDay();
                    if (w !== 0 && w !== 6) count++;
                }
                return count;
            }

            // Saat jenis cuti berubah
            $("#jenis_cuti, #tgl_mulai_cuti").on("change", function() {
                const jenis = $("#jenis_cuti").val();
                const mulai = $("#tgl_mulai_cuti").val();

                if (!jenis) {
                    $("#tgl_selesai_cuti").val("").prop("readonly", false);
                    $("#lama_cuti").val("");
                    return;
                }

                if (cutiTetap[jenis] !== undefined) {
                    const hari = cutiTetap[jenis];
                    if (mulai) {
                        const selesai = hitungTanggalSelesaiKerja(mulai, hari);
                        $("#tgl_selesai_cuti").val(selesai).prop("readonly", true);
                        $("#lama_cuti").val(hari);
                    }
                } else if (jenis === "Cuti Tahunan") {
                    $("#tgl_selesai_cuti").prop("readonly", false);
                    const selesai = $("#tgl_selesai_cuti").val();
                    if (mulai && selesai) {
                        $("#lama_cuti").val(hitungSelisihHariKerja(mulai, selesai));
                    }
                }
            });

            // Validasi & hitung ulang jika user ubah tanggal selesai manual (Cuti Tahunan)
            $("#tgl_selesai_cuti").on("change", function() {
                const jenis = $("#jenis_cuti").val();
                if (jenis !== "Cuti Tahunan") return;

                const mulai = $("#tgl_mulai_cuti").val();
                const selesai = $(this).val();
                if (!mulai || !selesai) return;

                if (new Date(selesai) < new Date(mulai)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tanggal Selesai tidak boleh lebih awal dari Tanggal Mulai!'
                    });
                    $(this).val('');
                    $("#lama_cuti").val('');
                    return;
                }

                $("#lama_cuti").val(hitungSelisihHariKerja(mulai, selesai));
            });


            // Fungsi gabung jam:menit menjadi HH:MM:SS
            function combineTimeValues() {
                const h1 = $("#jam_mulai_hour").val(),
                    m1 = $("#jam_mulai_minute").val(),
                    h2 = $("#jam_selesai_hour").val(),
                    m2 = $("#jam_selesai_minute").val();

                if (h1 && m1) {
                    $("#jam_mulai_hidden").val(`${h1}:${m1}:00`);
                }
                if (h2 && m2) {
                    $("#jam_selesai_hidden").val(`${h2}:${m2}:00`);
                }
            }

            // Trigger combine setiap select berubah
            $("#jam_mulai_hour, #jam_mulai_minute, #jam_selesai_hour, #jam_selesai_minute")
                .on("change", combineTimeValues);

            // Validasi & submit form-cuti
            $("#form-cuti").on("submit", function(e) {
                // … (tetap seperti semula) …
                return true;
            });

            // Validasi & submit form-ijin
            $("#form-ijin").on("submit", function(e) {
                combineTimeValues();
                // … (tetap seperti semula) …
                return true;
            });

            // Inisialisasi: kalau sudah ada nilai default
            if ($("#jenis_cuti").val() && $("#tgl_mulai_cuti").val()) {
                $("#jenis_cuti").trigger("change");
            }
        });
    </script>
@endpush

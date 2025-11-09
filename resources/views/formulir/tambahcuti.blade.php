@extends('layouts.presensiform')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:history.back()" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Formulir Cuti</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 75px">
        <div class="col" style="margin-left: 1px;margin-right: 1px">
            <div class="px-3">
                <form action="{{ route('store.cuti') }}" method="POST" id="form-cuti" enctype="multipart/form-data">
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
                    <input type="date" name="tgl_mulai" id="tgl_mulai_cuti" class="form-control mb-2" required>

                    <div id="tgl_selesai_container">
                        <label class="mt-2" style="font-weight: 700">Tanggal Selesai Cuti</label>
                        <input type="date" name="tgl_selesai" id="tgl_selesai_cuti" class="form-control mb-2" required>
                    </div>

                    <label class="mt-2" style="font-weight: 700">Lama Cuti (Hari)</label>
                    <input type="text" name="lama_cuti" id="lama_cuti" class="form-control mb-2" readonly>

                    <label style="font-weight: 700">Keterangan</label>
                    <textarea name="keterangan" id="keterangan_cuti" class="form-control mb-2" style="min-height: 100px; resize: vertical;"
                        placeholder="Masukkan Keterangan Lengkap" required></textarea>

                    <label style="font-weight: 700">Lampiran Foto (Jika Ada)</label>
                    <input type="file" name="bukti" id="bukti_cuti" class="form-control mb-2">

                    <button type="submit" class="btn btn-primary w-100 mt-2 mb-5">
                        <ion-icon name="paper-plane"></ion-icon> Ajukan Cuti
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
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
        });
    </script>
@endpush

@extends('layouts.presensiform')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:history.back()" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Formulir Cuti</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="row" style="margin-top: 75px">
        <div class="col" style="margin-left: 1px;margin-right: 1px">
            <div class="px-3">
                <form action="{{ route('update.cuti', $formulir->id_formulir) }}" method="POST" id="form-cuti"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" value="Cuti">

                    <label style="font-weight: 700">Jenis Cuti</label>
                    <select name="jenis_cuti" id="jenis_cuti" class="form-control mb-2" required>
                        <option value="">-- Pilih Jenis Cuti --</option>
                        <option value="Cuti Tahunan" @selected($formulir->jenis_cuti == 'Cuti Tahunan')>Cuti Tahunan</option>
                        <option value="Cuti Melahirkan" @selected($formulir->jenis_cuti == 'Cuti Melahirkan')>Cuti Melahirkan</option>
                        <option value="Cuti Menikah" @selected($formulir->jenis_cuti == 'Cuti Menikah')>Cuti Menikah</option>
                        <option value="Cuti Menikahkan Anak" @selected($formulir->jenis_cuti == 'Cuti Menikahkan Anak')>Cuti Menikahkan Anak</option>
                        <option value="Cuti Anak Sunat / Baptis" @selected($formulir->jenis_cuti == 'Cuti Anak Sunat / Baptis')>Cuti Anak Sunat / Baptis
                        </option>
                        <option value="Cuti Istri Melahirkan" @selected($formulir->jenis_cuti == 'Cuti Istri Melahirkan')>Cuti Istri Melahirkan</option>
                        <option value="Cuti Keluarga Meninggal" @selected($formulir->jenis_cuti == 'Cuti Keluarga Meninggal')>Cuti Keluarga Meninggal
                        </option>
                        <option value="Cuti Panggilan Negara" @selected($formulir->jenis_cuti == 'Cuti Panggilan Negara')>Cuti Panggilan Negara</option>
                        <option value="Cuti Haji / Umroh" @selected($formulir->jenis_cuti == 'Cuti Haji / Umroh')>Cuti Haji / Umroh</option>
                    </select>

                    <label class="mt-2" style="font-weight: 700">Tanggal Mulai Cuti</label>
                    <input type="date" name="tgl_mulai" value="{{ $formulir->tgl_mulai }}" id="tgl_mulai_cuti"
                        class="form-control mb-2" required>

                    <div id="tgl_selesai_container">
                        <label class="mt-2" style="font-weight: 700">Tanggal Selesai Cuti</label>
                        <input type="date" name="tgl_selesai" value="{{ $formulir->tgl_selesai }}" id="tgl_selesai_cuti"
                            class="form-control mb-2" required>
                    </div>

                    <label class="mt-2" style="font-weight: 700">Lama Cuti (Hari)</label>
                    <input type="text" name="lama_cuti" value="{{ $formulir->lama_cuti }}" id="lama_cuti"
                        class="form-control mb-2" readonly>

                    <label style="font-weight: 700">Keterangan</label>
                    <textarea name="keterangan" id="keterangan_cuti" class="form-control mb-2" style="min-height: 100px; resize: vertical;"
                        placeholder="Masukkan Keterangan Lengkap" required>{{ old('keterangan', $formulir->keterangan) }}</textarea>

                    <label style="font-weight: 700">Lampiran Foto (Jika Ada)</label>
                    @if ($formulir->bukti)
                        <div class="mb-1">
                            <a href="#" class="btn btn-warning w-100 lihat-bukti"
                                data-foto="{{ asset('storage/upload/bukti/' . $formulir->bukti) }}">
                                Lihat lampiran sebelumnya
                            </a>
                        </div>
                    @endif
                    <input type="file" name="bukti" id="bukti_cuti" class="form-control mb-2">

                    <button type="submit" class="btn btn-primary w-100 mt-5 mb-5">
                        <ion-icon name="paper-plane"></ion-icon> Update Formulir
                    </button>
                </form>
                <!-- Modal Preview Bukti -->
                <div class="modal fade" id="modalBukti" tabindex="-1" aria-labelledby="modalBuktiLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title w-100 text-center fw-bold" id="modalBuktiLabel">Preview Lampiran</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="bukti-image" src="" alt="Lampiran Foto" class="img-fluid" />
                            </div>
                        </div>
                    </div>
                </div>
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
            // Debug: Cek library yang tersedia
            console.log('jQuery version:', $.fn.jquery);
            console.log('Bootstrap modal function:', typeof $.fn.modal);
            console.log('Modal element:', $('#modalBukti').length);
            console.log('Button element:', $('.lihat-bukti').length);

            // Fungsi untuk show modal dengan fallback
            function showModal() {
                try {
                    // Coba Bootstrap modal terlebih dahulu
                    if (typeof $.fn.modal === 'function') {
                        $('#modalBukti').modal('show');
                    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        // Fallback ke Bootstrap 5
                        const modalEl = document.getElementById('modalBukti');
                        const modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    } else {
                        // Fallback manual show modal
                        $('#modalBukti').addClass('show').css('display', 'block');
                        $('body').addClass('modal-open');
                        $('.modal-backdrop').remove();
                        $('<div class="modal-backdrop fade show"></div>').appendTo('body');
                    }
                } catch (error) {
                    console.error('Error showing modal:', error);
                    // Fallback terakhir - tampilkan dengan CSS
                    $('#modalBukti').addClass('show').css('display', 'block');
                    $('body').addClass('modal-open');
                }
            }

            // Fungsi untuk hide modal
            function hideModal() {
                $('#modalBukti').removeClass('show').css('display', 'none');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            }

            // Event handler untuk tombol lihat bukti - FIXED dengan fallback
            $(document).on('click', '.lihat-bukti', function(e) {
                e.preventDefault();
                console.log('Button clicked!'); // Debug log

                const imageUrl = $(this).data('foto');
                console.log('Image URL:', imageUrl); // Debug log

                if (imageUrl) {
                    $('#bukti-image').attr('src', imageUrl);

                    // Handle error loading image
                    $('#bukti-image').off('error').on('error', function() {
                        console.error('Failed to load image:', imageUrl);
                        $(this).attr('alt', 'Gambar tidak dapat dimuat');
                        $(this).attr('src',
                            'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCxzYW5zLXNlcmlmIiBmb250LXNpemU9IjE0IiBmaWxsPSIjOTk5IiB0ZXh0LWFuY2hvcj0ibWlkZGxlIiBkeT0iLjNlbSI+R2FtYmFyIHRpZGFrIGRpdGVtdWthbjwvdGV4dD48L3N2Zz4='
                        );
                    });

                    // Show modal dengan fallback
                    showModal();
                } else {
                    console.error('No image URL found');
                    alert('URL gambar tidak ditemukan');
                }
            });

            // Event handler untuk close modal
            $(document).on('click', '[data-dismiss="modal"], .modal-backdrop', function() {
                hideModal();
            });

            // ESC key untuk close modal
            $(document).on('keydown', function(e) {
                if (e.keyCode === 27 && $('#modalBukti').hasClass('show')) {
                    hideModal();
                }
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

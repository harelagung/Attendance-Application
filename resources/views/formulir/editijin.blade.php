@extends('layouts.presensiform')

@section('header')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:history.back()" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Formulir Ijin</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    @php
        // Ekstrak jam dan menit dari database atau old input
        $jamMulaiHour = old('jam_mulai_hour', isset($formulir->jam_mulai) ? substr($formulir->jam_mulai, 0, 2) : '');
        $jamMulaiMinute = old(
            'jam_mulai_minute',
            isset($formulir->jam_mulai) ? substr($formulir->jam_mulai, 3, 2) : '',
        );
        $jamSelesaiHour = old(
            'jam_selesai_hour',
            isset($formulir->jam_selesai) ? substr($formulir->jam_selesai, 0, 2) : '',
        );
        $jamSelesaiMinute = old(
            'jam_selesai_minute',
            isset($formulir->jam_selesai) ? substr($formulir->jam_selesai, 3, 2) : '',
        );
        $alasanDefault = old('alasan_ijin', $formulir->alasan_ijin ?? '');
    @endphp

    <div class="row" style="margin-top: 50px">
        <div class="col" style="margin-left: 1px;margin-right: 1px">
            <div class="px-3">
                <form action="{{ route('update.ijin', $formulir->id_formulir) }}" method="POST" id="form-ijin"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="status" value="Ijin">

                    <label class="mt-2" style="font-weight: 700">Tanggal Ijin</label>
                    <input type="date" name="tgl_ijin" id="tgl_ijin" class="form-control mb-2"
                        value="{{ old('tgl_ijin', $formulir->tgl_ijin) }}" required>

                    <div class="form-group">
                        <label style="font-weight: 700">Jam Mulai <small class="text-muted">(Format 24 Jam)</small></label>
                        <div class="input-group">
                            <select name="jam_mulai_hour" id="jam_mulai_hour" class="form-control" required>
                                <option value="">Jam</option>
                                @for ($i = 0; $i < 24; $i++)
                                    @php $H = sprintf('%02d', $i); @endphp
                                    <option value="{{ $H }}" {{ $jamMulaiHour === $H ? 'selected' : '' }}>
                                        {{ $H }}</option>
                                @endfor
                            </select>
                            <span class="input-group-text">:</span>
                            <select name="jam_mulai_minute" id="jam_mulai_minute" class="form-control" required>
                                <option value="">Menit</option>
                                @for ($i = 0; $i < 60; $i++)
                                    @php $M = sprintf('%02d', $i); @endphp
                                    <option value="{{ $M }}" {{ $jamMulaiMinute === $M ? 'selected' : '' }}>
                                        {{ $M }}</option>
                                @endfor
                            </select>
                            <input type="hidden" name="jam_mulai" id="jam_mulai_hidden">
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 700">Jam Selesai <small class="text-muted">(Format 24
                                Jam)</small></label>
                        <div class="input-group">
                            <select name="jam_selesai_hour" id="jam_selesai_hour" class="form-control" required>
                                <option value="">Jam</option>
                                @for ($i = 0; $i < 24; $i++)
                                    @php $H2 = sprintf('%02d', $i); @endphp
                                    <option value="{{ $H2 }}" {{ $jamSelesaiHour === $H2 ? 'selected' : '' }}>
                                        {{ $H2 }}</option>
                                @endfor
                            </select>
                            <span class="input-group-text">:</span>
                            <select name="jam_selesai_minute" id="jam_selesai_minute" class="form-control" required>
                                <option value="">Menit</option>
                                @for ($i = 0; $i < 60; $i++)
                                    @php $M2 = sprintf('%02d', $i); @endphp
                                    <option value="{{ $M2 }}" {{ $jamSelesaiMinute === $M2 ? 'selected' : '' }}>
                                        {{ $M2 }}</option>
                                @endfor
                            </select>
                            <input type="hidden" name="jam_selesai" id="jam_selesai_hidden">
                        </div>
                    </div>

                    <label style="font-weight: 700">Alasan Ijin</label>
                    <select name="alasan_ijin" id="alasan_ijin" class="form-control mb-2" required>
                        <option value="">-- Pilih Alasan --</option>
                        @foreach (['Sakit', 'Urusan Keluarga', 'Dinas Luar', 'Pulang Cepat', 'Datang Terlambat'] as $alasan)
                            <option value="{{ $alasan }}" {{ $alasanDefault === $alasan ? 'selected' : '' }}>
                                {{ $alasan }}</option>
                        @endforeach
                    </select>

                    <label style="font-weight: 700">Keterangan</label>
                    <textarea name="keterangan" id="keterangan_ijin" class="form-control mb-2" style="min-height: 100px; resize: vertical;"
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
                    <input type="file" name="bukti" id="bukti_ijin" class="form-control mb-2">

                    <button type="submit" class="btn btn-primary w-100 mt-2 mb-5">
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

            // Validasi tanggal ijin
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
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                    }
                });
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

            // Validasi & submit form-ijin
            $("#form-ijin").on("submit", function(e) {
                combineTimeValues();

                // Validasi tambahan jika diperlukan
                const jamMulai = $("#jam_mulai_hidden").val();
                const jamSelesai = $("#jam_selesai_hidden").val();

                if (!jamMulai || !jamSelesai) {
                    e.preventDefault();
                    alert('Harap lengkapi jam mulai dan jam selesai');
                    return false;
                }

                return true;
            });

            // Inisialisasi combine time values jika ada data default
            combineTimeValues();
        });
    </script>
@endpush

@if ($history->isEmpty())
    <div class="alert">
        <b>
            <p class="mt-5" style="text-align: center; font-size: 1rem">Data Belum Ada</p>
        </b>
    </div>
@endif

@foreach ($history as $d)
    <ul class="listview image-listview">
        <li>
            <div class="item">
                @php
                    $path = Storage::url('upload/absensi/' . $d->foto_in);
                @endphp
                <img src="{{ url($path) }}" alt="image" class="image">
                <div class="in">
                    <div>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</div>
                    <!-- Logika untuk jam masuk -->
                    @if (($d->shift == 1 && $d->jam_in > '07:00:00') || ($d->shift == 2 && $d->jam_in > '19:00:00'))
                        <span class="badge badge-danger">{{ $d->jam_in }}</span>
                    @else
                        <span class="badge badge-success">{{ $d->jam_in }}</span>
                    @endif

                    <!-- Logika untuk jam pulang -->
                    @if ($d->jam_out != null)
                        @php
                            $shift2_cepat = false;
                            // Khusus untuk shift 2, perlu penanganan khusus karena bisa melewati tengah malam
                            if ($d->shift == 2) {
                                // Jam pulang dikonversi ke timestamp
                                $jam_out_time = strtotime($d->jam_out);
                                // Batas waktu pulang untuk shift 2 (jam 3 pagi)
                                $batas_shift2 = strtotime('03:00:00');

                                // Jika jam pulang di bawah jam 12 siang, berarti sudah lewat tengah malam
                                // dan kita bandingkan dengan batas jam 3 pagi (03:00:00)
                                if ($jam_out_time <= strtotime('12:00:00')) {
                                    $shift2_cepat = $jam_out_time < $batas_shift2;
                                } else {
                                    // Jika pulang sebelum tengah malam, berarti terlalu cepat (harusnya sampai jam 3 pagi)
                                    $shift2_cepat = true;
                                }
                            }
                        @endphp

                        @if (($d->shift == 1 && $d->jam_out < '16:00:00') || ($d->shift == 2 && $shift2_cepat))
                            <span class="badge badge-danger">{{ $d->jam_out }}</span>
                        @else
                            <span class="badge badge-success">{{ $d->jam_out }}</span>
                        @endif
                    @else
                        <span class="badge badge-warning">Belum Absen</span>
                    @endif
                </div>
            </div>
            </div>
        </li>
    </ul>
@endforeach

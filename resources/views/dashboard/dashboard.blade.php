@extends('layouts.presensi')

@section('content')
    <div class="section" id="user-section">
        <div id="user-detail">
            <div class="avatar mt-1">
                <img src="{{ asset('storage/upload/foto_karyawan/' . Auth::user()->foto) }}" alt="avatar"
                    class="rounded-leaf" style="width: 70px; height: 75px; object-fit: cover;"
                    onerror="this.src='{{ asset('assets/img/sample/avatar/avatar1.jpg') }}'">
            </div>
            <div class="mt-2" id="user-info">
                <h2 id="user-name">{{ Auth::user()->nama }}</h2>
                <span id="user-role">{{ Auth::user()->department }}</span>
            </div>
        </div>
    </div>

    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu">
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/create" class="green" style="font-size: 40px;">
                                <ion-icon name="finger-print"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            Presensi
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/formulir" class="danger" style="font-size: 40px;">
                                <ion-icon name="documents"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Formulir</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="/presensi/history" class="warning" style="font-size: 40px;">
                                <ion-icon name="book"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">History</span>
                        </div>
                    </div>
                    <div class="item-menu text-center">
                        <div class="menu-icon">
                            <a href="{{ route('profil.tampil') }}" class="orange" style="font-size: 40px;">
                                <ion-icon name="person-sharp"></ion-icon>
                            </a>
                        </div>
                        <div class="menu-name">
                            <span class="text-center">Profil</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section mt-2" id="presence-section">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null)
                                        @php
                                            $path = Storage::url('upload/absensi/' . $presensihariini->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="log-in-outline"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensihariini != null ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensihariini != null && $presensihariini->foto_out != null)
                                        @php
                                            $path = Storage::url('upload/absensi/' . $presensihariini->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="home"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <span>{{ $presensihariini != null && $presensihariini->jam_out != null ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="rekappresensi">
            <h3>Rekap Presensi {{ $namabulan[$bulanini] }} {{ $tahunini }}</h3>
            <div class="row">
                <div class="col-3">
                    <a href="#" class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:2px; right:2px; font-size:0.8rem; z-index:9900">{{ $rekappresensi->jmlhadir != null ? $rekappresensi->jmlhadir : 0 }}</span>
                            <ion-icon name="accessibility-outline" style="font-size: 1.5rem"
                                class="text-primary mb-1"></ion-icon><br>
                            <span style="font-size: 0.8rem; font-weight:800;color:rgb(91, 91, 91)">Hadir</span>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="/presensi/rekapijin" class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:2px; right:2px; font-size:0.8rem; z-index:9900">{{ $datarekap->jmlijin != null ? $datarekap->jmlijin : 0 }}</span>
                            <ion-icon name="newspaper-outline" style="font-size: 1.5rem"
                                class="text-success mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:800; color:rgb(91, 91, 91)">Ijin</span>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="/presensi/rekapcuti" class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:2px; right:2px; font-size:0.8rem; z-index:9990">{{ $datarekap->jmlcuti != null ? $datarekap->jmlcuti : 0 }}</span>
                            <ion-icon name="calendar-outline" style="font-size: 1.5rem"
                                class="text-warning mb-1"></ion-icon>
                            <br>
                            <span style="font-size: 0.8rem; font-weight:800;color:rgb(91, 91, 91)">Cuti</span>
                        </div>
                    </a>
                </div>
                <div class="col-3">
                    <a href="#" class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height:0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:2px; right:2px; font-size:0.8rem; z-index:9900">{{ $rekappresensi->jmlterlambat != null ? $rekappresensi->jmlterlambat : 0 }}</span>
                            <ion-icon name="alarm-outline" style="font-size: 1.5rem"
                                class="text-danger mb-1"></ion-icon><br>
                            <span style="font-size: 0.8rem; font-weight:800;color:rgb(91, 91, 91)">Telat</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <ul class="listview image-listview" style="margin-top: 3px">
                                @foreach ($historybulanini as $d)
                                    <li>
                                        <div class="item" style="padding: 10px 1px">
                                            <div class="icon-box bg-primary">
                                                <ion-icon name="checkmark-done"></ion-icon>
                                            </div>
                                            <div class="in"
                                                style="font-size: 0.8rem; font-weight:700; color:rgb(84, 84, 84)">
                                                <div>Shift {{ $d->shift }} <br>
                                                    {{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</div>

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
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <ul class="listview image-listview">
                                @if ($leaderboard->isEmpty())
                                    <li>
                                        <div class="text-center">
                                            <span style="color: rgba(79, 79, 79, 0.639);font-weight:500">Data Tidak
                                                Ditemukan</span>
                                        </div>
                                    </li>
                                @else
                                    @foreach ($leaderboard as $d)
                                        <li>
                                            <div class="item">
                                                <img src="{{ asset('storage/upload/foto_karyawan/' . $d->foto) }}"
                                                    alt="image" class="rounded-circle"
                                                    style="width: 30px; height: 30px; object-fit: cover; border-radius: 50%;"
                                                    onerror="this.src='{{ asset('assets/img/sample/avatar/avatar1.jpg') }}'">

                                                <div class="in">
                                                    <div style="text-align:center; margin-left:1rem;">
                                                        <b>{{ $d->nama }}</b>
                                                    </div>
                                                    @if (($d->shift == 1 && $d->jam_in > '07:00:00') || ($d->shift == 2 && $d->jam_in > '19:00:00'))
                                                        <span class="badge bg-danger">{{ $d->jam_in }}</span>
                                                    @else
                                                        <span class="badge bg-success">{{ $d->jam_in }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ' jam ' . round($sisamenit2) . ' menit';
    }

    // Kelompokkan presensi untuk paginasi (misalnya 10 entri per halaman)
    $itemsPerPage = 12;

    // Konversi koleksi Eloquent menjadi array terlebih dahulu
    // Jika $presensi adalah objek stdClass, konversi ke array dulu
    $presensiArray = [];
    foreach ($presensi as $item) {
        if (is_object($item)) {
            $presensiArray[] = (array) $item;
        } else {
            $presensiArray[] = $item;
        }
    }

    $presensiBatches = array_chunk($presensiArray, $itemsPerPage);
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Cetak Presensi</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/login/logo ihara.png') }}" sizes="32x32">

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        body {
            margin: 0;
        }

        .tabledatakaryawan {
            margin-top: 40px;
        }

        .tabledatakaryawan td {
            padding: 3px
        }

        .tablepresensi {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            page-break-after: auto;
        }

        .tablepresensi th {
            border: 2px solid #6c6c6c;
            padding: 8px;
            background: #c1c1c1;
        }

        .tablepresensi td {
            border: 2px solid #6c6c6c;
            padding: 5px;
        }

        /* Styling untuk footer dengan posisi tetap */
        .footer {
            position: absolute;
            bottom: 30px;
            right: 50px;
            width: auto;
            text-align: right;
            color: #919191
        }

        .footer2 {
            position: absolute;
            bottom: 30px;
            left: 50px;
            width: auto;
            text-align: left;
            color: #919191
        }

        /* Styling untuk tanda tangan */
        .signature-table {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 50px;
            /* Memberi ruang antara tabel dan footer */
            border-collapse: collapse;
        }

        .signature-table td {
            padding: 15px;
            text-align: center;
        }

        /* Page break inside avoid untuk header tabel */
        .tablepresensi thead {
            display: table-header-group;
        }

        /* Page break inside avoid untuk baris tabel */
        .tablepresensi tr {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        /* CSS untuk header yang berulang pada setiap halaman */
        .header {
            width: 90%;
            margin: 0 auto;
        }

        /* Halaman lanjutan */
        .continuation-header {
            margin-bottom: 10px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">

    <!-- Halaman Pertama dengan info karyawan -->
    <section class="sheet padding-10mm">
        <!-- Header perusahaan -->
        <table class="header">
            <tr>
                <td style="width: 120px">
                    <center>
                        <img src="{{ asset('assets/img/logo ihara.png') }}" width="80" height="40"
                            alt="">
                    </center>
                </td>
                <td>
                    <center>
                        <h3 style="margin-bottom: 3px">
                            LAPORAN PRESENSI KARAYAWAN <br>
                            PERIODE BULAN {{ $namabulan[$bulan] }} {{ $tahun }}<br>
                            PT. IHARA MANUFACTURING INDONESIA</h3>
                        <span>Jl. Maligi Raya Kawasan Industri KIIC Lot G-1A & B, Sukaluyu, Telukjambe Timur, Karawang,
                            Jawa Barat 41361</span>
                    </center>
                </td>
            </tr>
        </table>
        <h4 style="margin-top: 50px;margin-bottom: -20px">History Presensi Karyawan :</h4>
        <table class="tabledatakaryawan">
            <tr>
                <td rowspan="6" style="padding-right: 45px">
                    @php
                        $path = Storage::url('upload/foto_karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" style="width: 120px; height: 180px" alt="">
                </td>
            </tr>
            <tr>
                <td><b>NIK</b></td>
                <td>:</td>
                <td>{{ $karyawan->id_karyawan }}</td>
            </tr>
            <tr>
                <td><b>Nama Karyawan</b></td>
                <td>:</td>
                <td>{{ $karyawan->nama }}</td>
            </tr>
            <tr>
                <td><b>Department</b></td>
                <td>:</td>
                <td>{{ $karyawan->department }}</td>
            </tr>
            <tr>
                <td><b>Jabatan</b></td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td><b>No. Hp</b></td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>

        <!-- Tabel presensi untuk halaman pertama -->
        <table id="tablepresensi" class="tablepresensi">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Foto Masuk</th>
                    <th>Jam Pulang</th>
                    <th>Foto Pulang</th>
                    <th>Keterangan</th>
                    <th>Total Jam Kerja</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 1; @endphp
                @foreach ($presensiBatches[0] ?? [] as $d)
                    @php
                        // Menangani $d baik sebagai object maupun array
                        $fotoIn = is_array($d) ? $d['foto_in'] : $d->foto_in;
                        $fotoOut = is_array($d) ? $d['foto_out'] ?? null : $d->foto_out ?? null;
                        $pathIn = Storage::url('upload/absensi/' . $fotoIn);
                        $pathOut = $fotoOut ? Storage::url('upload/absensi/' . $fotoOut) : null;
                    @endphp
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ date('d-m-Y', strtotime(is_array($d) ? $d['tgl_presensi'] : $d->tgl_presensi)) }}</td>
                        <td>
                            <center>{{ is_array($d) ? $d['jam_in'] : $d->jam_in }}</center>
                        </td>
                        <td>
                            <center><img src="{{ url($pathIn) }}" style="width: 70px; height: 50px" alt="">
                            </center>
                        </td>
                        <td>
                            <center>
                                @php
                                    $jamOut = is_array($d) ? $d['jam_out'] ?? null : $d->jam_out ?? null;
                                @endphp
                                {{ $jamOut != null ? $jamOut : 'Belum Absen Pulang' }}
                            </center>
                        </td>
                        <td>
                            <center>
                                @if ($jamOut != null)
                                    <img src="{{ url($pathOut) }}" style="width: 70px; height: 50px" alt="">
                                @else
                                    -
                                @endif
                            </center>
                        </td>
                        <td>
                            @php
                                $shift = is_array($d) ? $d['shift'] ?? 1 : $d->shift ?? 1;
                                $jamIn = is_array($d) ? $d['jam_in'] : $d->jam_in;
                            @endphp
                            @if (($shift == 1 && $jamIn > '07:00:00') || ($shift == 2 && $jamIn > '19:00:00'))
                                @php
                                    $jamterlambat = selisih('07:00:00', $jamIn);
                                @endphp
                                <span class="badge badge bg-danger">Terlambat <br> {{ $jamterlambat }}</span>
                            @else
                                <span class="badge badge bg-success"> </span>
                            @endif
                        </td>
                        <td>
                            <center>
                                @if ($jamOut != null)
                                    @php
                                        $jmljamkerja = selisih($jamIn, $jamOut);
                                    @endphp
                                @else
                                    @php
                                        $jmljamkerja = 0;
                                    @endphp
                                @endif
                                {{ $jmljamkerja }} Jam
                            </center>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Tabel tanda tangan -->
        <table class="signature-table" border="1">
            <tr>
                <td style="text-align: center">
                    Dibuat Oleh
                </td>
                <td style="text-align: center">
                    Diketahui Oleh
                </td>
            </tr>
            <tr>
                <td style="text-align: center; vertical-align: bottom" height="100">
                    {{ Auth::user()->jabatan }} {{ Auth::user()->department }} <br>
                    <b>{{ Auth::user()->nama }}</b>
                </td>
                <td style="text-align: center; vertical-align: bottom" height="100">
                    Manager HR <br>
                    <b>Fujiwara</b>
                </td>
            </tr>
        </table>
        <!-- Footer dengan tanggal pada halaman pertama -->
        <div class="footer">
            <i>Dicetak pada tanggal {{ date('d-m-Y') }} {{ date('H:i:s') }}</i>
        </div>
        <div class="footer2">
            <i>Halaman 1</i>
        </div>
    </section>

    <!-- Halaman Tambahan jika diperlukan -->
    @for ($i = 1; $i < count($presensiBatches); $i++)
        <section class="sheet padding-10mm">
            <!-- Tabel presensi untuk halaman lanjutan -->
            <table class="tablepresensi">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Foto Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Foto Pulang</th>
                        <th>Keterangan</th>
                        <th>Total Jam Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @php $counter = $i * $itemsPerPage + 1; @endphp
                    @foreach ($presensiBatches[$i] as $d)
                        @php
                            // Menangani $d baik sebagai object maupun array
                            $fotoIn = is_array($d) ? $d['foto_in'] : $d->foto_in;
                            $fotoOut = is_array($d) ? $d['foto_out'] ?? null : $d->foto_out ?? null;
                            $pathIn = Storage::url('upload/absensi/' . $fotoIn);
                            $pathOut = $fotoOut ? Storage::url('upload/absensi/' . $fotoOut) : null;
                        @endphp
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td>{{ date('d-m-Y', strtotime(is_array($d) ? $d['tgl_presensi'] : $d->tgl_presensi)) }}
                            </td>
                            <td>
                                <center>{{ is_array($d) ? $d['jam_in'] : $d->jam_in }}</center>
                            </td>
                            <td>
                                <center><img src="{{ url($pathIn) }}" style="width: 70px; height: 50px"
                                        alt=""></center>
                            </td>
                            <td>
                                <center>
                                    @php
                                        $jamOut = is_array($d) ? $d['jam_out'] ?? null : $d->jam_out ?? null;
                                    @endphp
                                    {{ $jamOut != null ? $jamOut : 'Belum Absen Pulang' }}
                                </center>
                            </td>
                            <td>
                                <center>
                                    @if ($jamOut != null)
                                        <img src="{{ url($pathOut) }}" style="width: 70px; height: 50px"
                                            alt="">
                                    @else
                                        -
                                    @endif
                                </center>
                            </td>
                            <td>
                                @php
                                    $shift = is_array($d) ? $d['shift'] ?? 1 : $d->shift ?? 1;
                                    $jamIn = is_array($d) ? $d['jam_in'] : $d->jam_in;
                                @endphp
                                @if (($shift == 1 && $jamIn > '07:00:00') || ($shift == 2 && $jamIn > '19:00:00'))
                                    @php
                                        $jamterlambat = selisih('07:00:00', $jamIn);
                                    @endphp
                                    <span class="badge badge bg-danger">Terlambat <br> {{ $jamterlambat }}</span>
                                @else
                                    <span class="badge badge bg-success"> </span>
                                @endif
                            </td>
                            <td>
                                <center>
                                    @if ($jamOut != null)
                                        @php
                                            $jmljamkerja = selisih($jamIn, $jamOut);
                                        @endphp
                                    @else
                                        @php
                                            $jmljamkerja = 0;
                                        @endphp
                                    @endif
                                    {{ $jmljamkerja }} Jam
                                </center>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Footer dengan tanggal pada halaman lanjutan -->
            <div class="footer">
                <i>Halaman {{ $i + 1 }}</i><br>
                <i>Dicetak pada tanggal {{ date('d-m-Y') }} {{ date('H:i:s') }}</i>
            </div>
        </section>
    @endfor
</body>

</html>

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
    $maxRowsPerPage = 6;
    $totalRows = $presensi->count();
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

        .signature-wrapper {
            /* jangan potong konten di dalamnya */
            page-break-inside: avoid;
            -webkit-page-break-inside: avoid;
            break-inside: avoid;
            /* jadikan satu blok agar engine cetak menganggapnya utuh */
            display: inline-block;
            width: 100%;
        }

        /* Styling untuk tanda tangan */
        .signature-table {
            width: 100%;
            margin-top: 60px;
            margin-bottom: 100px;
            /* Memberi ruang antara tabel dan footer */
            border-collapse: collapse;
        }

        .signature-table td {
            padding: 15px;
            text-align: center;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">

        <table style="width: 90%">
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
        <table id="tablepresensi" class="tablepresensi">
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
            @foreach ($presensi as $d)
                @php
                    $pathIn = Storage::url('upload/absensi/' . $d->foto_in);
                    $pathOut = Storage::url('upload/absensi/' . $d->foto_out);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($d->tgl_presensi)) }}</td>
                    <td>
                        <center>{{ $d->jam_in }}</center>
                    </td>
                    <td>
                        <center><img src="{{ url($pathIn) }}" style="width: 70px; height: 50px" alt="">
                        </center>
                    </td>
                    <td>
                        <center>
                            {{ $d->jam_out != null ? $d->jam_out : 'Belum Absen Pulang' }}
                        </center>
                    </td>
                    <td>
                        <center>
                            @if ($d->jam_out != null)
                                <img src="{{ url($pathOut) }}" style="width: 70px; height: 50px" alt="">
                            @else
                                -
                            @endif
                        </center>
                    </td>
                    <td>
                        <center>
                            @php
                                $jamReferensi = $d->shift == 1 ? '07:00:00' : '19:00:00';
                                $isTerlambat =
                                    ($d->shift == 1 && $d->jam_in > '07:00:00') ||
                                    ($d->shift == 2 && $d->jam_in > '19:00:00');
                            @endphp
                            @if ($isTerlambat)
                                @php
                                    $jamterlambat = selisih($jamReferensi, $d->jam_in);
                                @endphp
                                <span class="badge badge bg-danger">Terlambat <br> {{ $jamterlambat }}</span>
                            @else
                                <span class="badge badge bg-success"> </span>
                            @endif
                        </center>
                    </td>
                    <td>
                        <center>
                            @if ($d->jam_out != null)
                                @php
                                    $jmljamkerja = selisih($d->jam_in, $d->jam_out);
                                @endphp
                            @else
                                @php
                                    $jmljamkerja = 0;
                                @endphp
                            @endif
                            {{ $jmljamkerja }}
                        </center>
                    </td>
                </tr>
            @endforeach
        </table>
        <div class="footer">
            <i>Dicetak pada tanggal {{ date('d-m-Y') }} {{ date('H:i:s') }}</i>
        </div>
        @if ($totalRows >= $maxRowsPerPage)
    </section>

    <section class="sheet padding-10mm">
        @endif
        <!-- Tabel tanda tangan -->
        <div class="signature-wrapper">
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
        </div>

        <!-- Footer dengan tanggal -->
        <div class="footer">
            <i>Dicetak pada tanggal {{ date('d-m-Y') }} {{ date('H:i:s') }}</i>
        </div>
    </section>

</body>

</html>

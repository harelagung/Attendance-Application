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
            size: A3 landscape
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
            font-size: 10px;
        }

        .tablepresensi td {
            border: 2px solid #6c6c6c;
            padding: 5px;
            font-size: 10px;
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

<body class="A3 landscape">

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
                            REKAP PRESENSI KARAYAWAN <br>
                            PERIODE BULAN {{ $namabulan[$bulan] }} {{ $tahun }}<br>
                            PT. IHARA MANUFACTURING INDONESIA</h3>
                        <span>Jl. Maligi Raya Kawasan Industri KIIC Lot G-1A & B, Sukaluyu, Telukjambe Timur, Karawang,
                            Jawa Barat 41361</span>
                    </center>
                </td>
            </tr>
        </table>

        <table class="tablepresensi">
            <tr>
                <th rowspan="2">NIK</th>
                <th rowspan="2">Nama</th>
                <th colspan="31">Tanggal</th>
                <th rowspan="2">TH</th>
                <th rowspan="2">TL</th>
            </tr>
            <tr>
                <?php
                for ($i = 1; $i <= 31; $i++) { 
            ?>
                <th>{{ $i }}</th>
                <?php                   
                }
            ?>
            </tr>
            @foreach ($rekap as $d)
                <tr>
                    <td>{{ $d->id_karyawan }}</td>
                    <td>{{ $d->nama }}</td>

                    <?php
                $totalhadir = 0;
                $totalterlambat = 0;
                    for ($i = 1; $i <= 31; $i++) { 
                        $tgl = "tgl_".$i;
                        $shift_key = "shift_".$i; // Pastikan shift per tanggal ada
                        $currentShift = $d->$shift_key ?? 1;

                        $hadir = explode("-", $d->$tgl);
                        if (empty($d->$tgl)) {
                            $hadir = ['',''];
                            $totalhadir += 0;
                        } else {
                            $hadir = explode("-", $d->$tgl);
                            $totalhadir += 1;
                            if (($currentShift == 1 && $hadir[0] > '07:00:00') || ($currentShift == 2 && $hadir[0] > '19:00:00')){
                                $totalterlambat += 1;
                            }
                        }

                        $jamMasuk = isset($hadir[0]) ? trim($hadir[0]) : '';
                        $jamPulang = isset($hadir[1]) ? trim($hadir[1]) : '';
                        
                ?>
                    <td>
                        @if (!empty($jamMasuk))
                            <!-- Debug: Tambahkan untuk melihat shift -->
                            {{-- <?php echo 'Shift: ' . $currentShift; ?> --}}

                            <!-- Warna merah untuk terlambat masuk -->
                            @if (($currentShift == 1 && $jamMasuk > '07:00:00') || ($currentShift == 2 && $jamMasuk > '19:00:00'))
                                <span style="color: red">{{ $jamMasuk }}</span>
                            @else
                                <span>{{ $jamMasuk }}</span>
                            @endif

                            <br>

                            <!-- Warna merah untuk pulang cepat atau NULL -->
                            @if ($jamPulang == 'NULL')
                                <span style="color: red">NULL</span>
                            @elseif (
                                ($currentShift == 1 && $jamPulang < '16:00:00') ||
                                    ($currentShift == 2 && (($jamPulang < '03:00:00' && $jamPulang >= '00:00:00') || $jamPulang >= '19:00:00')))
                                <span style="color: red">{{ $jamPulang }}</span>
                            @else
                                <span>{{ $jamPulang }}</span>
                            @endif
                        @endif
                    </td>
                    <?php                   
                    }
                ?>
                    <td>{{ $totalhadir }}</td>
                    <td>{{ $totalterlambat }}</td>
                </tr>
            @endforeach
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

        <!-- Footer dengan tanggal -->
        <div class="footer">
            <i>Dicetak pada tanggal {{ date('d-m-Y') }} {{ date('H:i:s') }}</i>
        </div>
    </section>

</body>

</html>

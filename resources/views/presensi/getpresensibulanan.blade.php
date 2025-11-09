@php
    function selisih($jam_masuk, $jam_keluar)
    {
        list($h, $m, $s) = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, "1", "1", "1");
        list($h, $m, $s) = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode(".", $totalmenit / 60);
        $sisamenit = ($totalmenit / 60) - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . " jam " . round($sisamenit2) . " menit";
    }
@endphp

<div>
    <span class="text-muted"> </span>
</div>

@foreach ($presensi as $d)
@php
    $foto_in = Storage::url('upload/absensi/'.$d->foto_in);
    $foto_out = Storage::url('upload/absensi/'.$d->foto_out);
@endphp
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->id_karyawan }}</td>
        <td>{{ $d->nama }}</td>
        <td>{{ $d->department }}</td>
        <td>{{ $d->shift }}</td>
        <td>{{ $d->tgl_presensi }}</td>
        <td>{{ $d->jam_in }}</td>
        <td>
            <img src="{{ url($foto_in) }}" class="avatar" alt=""
            onerror="this.src='{{ asset('assets/img/sample/avatar/avatar1.jpg') }}'">
        </td>
        <td>{!! $d->jam_out != null ? $d->jam_out : '<span class="badge bg-danger">Belum Absen Pulang</span>' !!}</td>
        <td>
            @if ($d->jam_out != null)
            <img src="{{ url($foto_out) }}" class="avatar" alt="">
            @else
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-hourglass-high"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6.5 7h11" /><path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" /><path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" /></svg>
            @endif
        </td>
        <td>
            @if ($d->shift == 1 && $d->jam_in > '07:00:00')
                @php
                    $jamterlambat = selisih('07:00:00', $d->jam_in);
                @endphp
            <span class="badge badge bg-danger">Terlambat <br> {{ $jamterlambat }}</span>
            @elseif ($d->shift == 2 && $d->jam_in > '19:00:00')
                @php
                    $jamterlambat = selisih('19:00:00', $d->jam_in);
                @endphp
            <span class="badge badge bg-danger">Terlambat <br> {{ $jamterlambat }}</span>
            @else
            <span class="badge badge bg-success">Ok</span>
            @endif
        </td>
    </tr> 
@endforeach 
<div class="mt-3">
    <span class="text-muted">Total: {{ count($presensi) }} data</span>
</div>
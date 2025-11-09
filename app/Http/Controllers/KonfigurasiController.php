<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KonfigurasiController extends Controller
{
    public function lokasikantor()
    {
        $hariini = date("Y-m-d");

        // Tambahan untuk ambil nama hari dan tanggal
        $namahari = ["", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"];
        $namabulan = [
            "",
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];

        $hari = $namahari[date("N")]; // date('N') = 1 (Senin) sampai 7 (Minggu)
        $tanggal = date("d");
        $bulan = $namabulan[(int) date("m")];
        $tahun = date("Y");

        $judul = "$hari, $tanggal $bulan $tahun";

        $lok_kantor = DB::table("lokasi")->where("id_lokasi", 1)->first();

        return view("konfigurasi.lokasi_kantor", compact("judul", "namabulan", "lok_kantor"));
    }

    public function updatelokasikantor(Request $request)
    {
        $lokasi_kantor = $request->lokasi_kantor;
        $radius = $request->radius;

        $update = DB::table("lokasi")
            ->where("id_lokasi", 1)
            ->update([
                "lokasi_kantor" => $lokasi_kantor,
                "radius" => $radius,
            ]);

        if ($update) {
            return Redirect::back()->with(["success" => "Lokasi Berhasil di Update"]);
        } else {
            return Redirect::back()->with(["warning" => "Lokasi Gagal di Update"]);
        }
    }
}

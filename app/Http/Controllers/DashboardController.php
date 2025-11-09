<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1; // berupa angka, contoh : 1 sebagai Januari
        $tahunini = date("Y"); // 2025
        $id_karyawan = Auth::user("karyawan")->id_karyawan;
        $presensihariini = DB::table("presensi")
            ->where("id_karyawan", $id_karyawan)
            ->where("tgl_presensi", $hariini)
            ->first();

        $historybulanini = DB::table("presensi")
            ->where("id_karyawan", $id_karyawan)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->orderBy("tgl_presensi")
            ->get();

        // Ambil informasi department user yang login
        $userInfo = DB::table("karyawan")->where("id_karyawan", $id_karyawan)->first();

        // Jika userInfo tidak ada, beri nilai default untuk menghindari error
        $userDepartment = $userInfo ? $userInfo->department : "";

        $rekappresensi = DB::table("presensi")
            ->selectRaw(
                '
        COUNT(id_karyawan) as jmlhadir, 
        SUM(
            CASE 
                WHEN shift = 1 AND jam_in > "07:00:00" THEN 1
                WHEN shift = 2 AND jam_in > "19:00:00" THEN 1
                ELSE 0
            END
        ) as jmlterlambat
        ',
            )
            ->where("id_karyawan", $id_karyawan)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->first();

        $leaderboard = DB::table("presensi")
            ->join("karyawan", "presensi.id_karyawan", "=", "karyawan.id_karyawan")
            ->where("tgl_presensi", $hariini)
            ->where("karyawan.department", $userDepartment)
            ->select("karyawan.nama", "karyawan.foto", "presensi.jam_in", "presensi.shift")
            ->orderBy("jam_in")
            ->get();

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

        $datarekap = DB::table("formulir")
            ->selectRaw('SUM(IF(status="Ijin",1,0)) as jmlijin, SUM(IF(status="Cuti",1,0)) as jmlcuti')
            ->where("id_karyawan", $id_karyawan)
            ->whereRaw('MONTH(tgl_formulir)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_formulir)="' . $tahunini . '"')
            ->where("status_approved", 1)
            ->first();
        return view(
            "dashboard.dashboard",
            compact(
                "presensihariini",
                "historybulanini",
                "namabulan",
                "bulanini",
                "tahunini",
                "rekappresensi",
                "leaderboard",
                "userDepartment",
                "datarekap",
            ),
        );
    }

    public function dashboardadmin(Request $request)
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

        $rekappresensi = DB::table("presensi")
            ->selectRaw(
                '
        COUNT(id_karyawan) as jmlhadir, 
        SUM(
            CASE 
                WHEN shift = 1 AND jam_in > "07:00:00" THEN 1
                WHEN shift = 2 AND jam_in > "19:00:00" THEN 1
                ELSE 0
            END
        ) as jmlterlambat
        ',
            )
            ->where("tgl_presensi", $hariini)
            ->first();

        $data_rekap_approved = DB::table("formulir")
            ->selectRaw('SUM(IF(status="Ijin",1,0)) as jmlijin_acc, SUM(IF(status="Cuti",1,0)) as jmlcuti_acc')
            ->where("tgl_formulir", $hariini)
            ->where("status_approved", 1)
            ->first();

        $data_rekap_pending = DB::table("formulir")
            ->selectRaw('SUM(IF(status="Ijin",1,0)) as jmlijin_pdg, SUM(IF(status="Cuti",1,0)) as jmlcuti_pdg')
            ->where("tgl_formulir", $hariini)
            ->where("status_approved", 0)
            ->first();

        $totalkaryawan = DB::table("karyawan")->count();

        return view(
            "/dashboard/dashboardadmin",
            compact("rekappresensi", "data_rekap_approved", "data_rekap_pending", "totalkaryawan", "judul"),
        );
    }
}

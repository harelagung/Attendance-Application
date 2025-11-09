<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $today = date("Y-m-d");
        $id_karyawan = Auth::user()->id_karyawan;
        $cek = DB::table("presensi")->where("tgl_presensi", $today)->where("id_karyawan", $id_karyawan)->count();
        return view("presensi.create", compact("cek"));
    }

    public function store(Request $request)
    {
        $id_karyawan = Auth::user()->id_karyawan;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s"); // Gunakan variabel jam untuk membuat nama file unik

        // RADIUS LOKASI KANTOR
        $latitudekantor = -6.333416687072655;
        $longitudekantor = 107.32564026189509;
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table("presensi")->where("tgl_presensi", $tgl_presensi)->where("id_karyawan", $id_karyawan)->count();

        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }

        $image = $request->image;
        // Buat folder jika belum ada
        $folderPath = "public/upload/absensi/";
        Storage::makeDirectory($folderPath, 0755, true);

        // Proses base64 string
        if (strpos($image, "data:image") !== false) {
            $image_parts = explode(",", $image);
            $image_base64 = base64_decode(end($image_parts));
        } elseif (strpos($image, ";base64,") !== false) {
            $image_parts = explode(";base64,", $image);
            $image_base64 = base64_decode($image_parts[1]);
        } else {
            $image_base64 = base64_decode($image);
        }

        // Buat nama file yang unik dengan menambahkan timestamp
        $timestamp = strtotime($jam); // Konversi jam ke timestamp
        $fileName = $id_karyawan . "-" . $tgl_presensi . "-" . $ket . ".png";
        // Atau gunakan format jam tanpa spasi dan karakter khusus
        // $fileName = $id_karyawan . "-" . $tgl_presensi . "-" . str_replace(":", "", $jam) . ".png";

        $file = $folderPath . $fileName;

        // Konversi data binari menjadi gambar
        $img = imagecreatefromstring($image_base64);

        if (!$img) {
            return "Error: Gagal membuat gambar dari data";
        }

        $outputPath = storage_path("app/" . $file);

        // Pastikan direktori ada
        $directory = dirname($outputPath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Simpan sebagai PNG dengan kualitas 80%
        $compression = 9 - round(9 * (80 / 100)); // Konversi kualitas 80% ke level kompresi 0-9

        // Simpan sebagai PNG
        imagepng($img, $outputPath, $compression);

        // Bebaskan memori
        imagedestroy($img);

        if ($jarak["meters"] > 20) {
            echo "error|Anda berada di luar radius!|out";
        } else {
            if ($cek > 0) {
                $data_pulang = [
                    "jam_out" => $jam,
                    "foto_out" => $fileName,
                    "lokasi_out" => $lokasi,
                ];
                $update = DB::table("presensi")
                    ->where("tgl_presensi", $tgl_presensi)
                    ->where("id_karyawan", $id_karyawan)
                    ->update($data_pulang);

                if ($update) {
                    echo "success|Terima Kasih!|out";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Gagal Absen!|out";
                }
            } else {
                $data = [
                    "id_karyawan" => $id_karyawan,
                    "tgl_presensi" => $tgl_presensi,
                    "jam_in" => $jam,
                    "foto_in" => $fileName,
                    "lokasi_in" => $lokasi,
                ];

                $simpan = DB::table("presensi")->insert($data);

                if ($simpan) {
                    echo "success|Terima Kasih!|out";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Gagal Absen!|out";
                }
            }
        }
    }
    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles =
            sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact("meters");
    }
}

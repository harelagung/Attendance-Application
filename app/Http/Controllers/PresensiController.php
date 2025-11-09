<?php
namespace App\Http\Controllers;

use App\Models\Formulir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use App\Models\Presensi; // Tambahkan import model Presensi
use Carbon\Carbon; // Tambahkan import Carbon untuk manipulasi tanggal/waktu
use Illuminate\Support\Facades\Redirect;

class PresensiController extends Controller
{
    public function create()
    {
        $today = date("Y-m-d");
        $id_karyawan = Auth::user()->id_karyawan;
        $cek = DB::table("presensi")->where("tgl_presensi", $today)->where("id_karyawan", $id_karyawan)->count();
        $lok_kantor = DB::table("lokasi")->where("id_lokasi", 1)->first();
        return view("presensi.create", compact("cek", "lok_kantor"));
    }

    public function store(Request $request)
    {
        $id_karyawan = Auth::user()->id_karyawan;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s"); // Gunakan variabel jam untuk membuat nama file unik
        $lok_kantor = DB::table("lokasi")->where("id_lokasi", 1)->first();
        $lok = explode(", ", $lok_kantor->lokasi_kantor);
        $lat_kantor = $lok[0];
        $long_kantor = $lok[1];

        // RADIUS LOKASI KANTOR
        $latitudekantor = $lat_kantor;
        $longitudekantor = $long_kantor;
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

        if ($radius > $lok_kantor->radius) {
            echo "error|Anda berada di luar radius!|out";
        } else {
            // Tentukan shift berdasarkan jam absen
            $jamAbsen = Carbon::parse($jam);
            $shift = $jamAbsen->between(Carbon::parse("03:00:00"), Carbon::parse("16:00:00")) ? 1 : 2;

            if ($cek > 0) {
                // PERUBAHAN: Menggunakan Eloquent untuk update data pulang
                $presensi = Presensi::where("tgl_presensi", $tgl_presensi)->where("id_karyawan", $id_karyawan)->first();

                if ($presensi) {
                    $presensi->jam_out = $jam;
                    $presensi->foto_out = $fileName;
                    $presensi->lokasi_out = $lokasi;
                    $updated = $presensi->save();

                    if ($updated) {
                        echo "success|Terima Kasih!|out";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Gagal Absen!|out";
                    }
                } else {
                    echo "error|Data presensi tidak ditemukan!|out";
                }
            } else {
                // PERUBAHAN: Menggunakan Eloquent untuk insert data masuk
                $presensi = new Presensi();
                $presensi->id_karyawan = $id_karyawan;
                $presensi->tgl_presensi = $tgl_presensi;
                $presensi->jam_in = $jam;
                $presensi->foto_in = $fileName;
                $presensi->lokasi_in = $lokasi;
                $presensi->shift = $shift; // Set shift secara langsung
                $simpan = $presensi->save();

                if ($simpan) {
                    echo "success|Terima Kasih!|in";
                    Storage::put($file, $image_base64);
                } else {
                    echo "error|Gagal Absen!|in";
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

    public function history()
    {
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
        return view("presensi.history", compact("namabulan"));
    }

    public function gethistory(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $id_karyawan = Auth::user()->id_karyawan;

        $history = DB::table("presensi")
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where("id_karyawan", $id_karyawan)
            ->orderBy("tgl_presensi")
            ->get();

        return view("presensi.gethistory", compact("history"));
    }

    public function rekapcuti()
    {
        $id_karyawan = Auth::user()->id_karyawan;
        $datarekap = DB::table("formulir")
            ->where("id_karyawan", $id_karyawan)
            ->where("status", "Cuti")
            ->select("*", "id_formulir")
            ->orderBy("tgl_mulai")
            ->get();
        return view("presensi.rekapcuti", compact("datarekap"));
    }

    public function rekapijin()
    {
        $id_karyawan = Auth::user()->id_karyawan;
        $datarekap = DB::table("formulir")
            ->where("id_karyawan", $id_karyawan)
            ->where("status", "Ijin")
            ->select("*", "id_formulir")
            ->orderBy("tgl_ijin")
            ->get();
        return view("presensi.rekapijin", compact("datarekap"));
    }

    public function formulir()
    {
        return view("presensi.formulir");
    }

    public function storeformulir(Request $request)
    {
        $id_karyawan = Auth::user()->id_karyawan;
        $tgl_formulir = date("Y-m-d");
        $status = $request->status;
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;
        $jenis_cuti = $request->jenis_cuti;
        $lama_cuti = $request->lama_cuti;
        $tgl_ijin = $request->tgl_ijin;
        $jam_mulai = $request->jam_mulai;
        $jam_selesai = $request->jam_selesai;
        $alasan_ijin = $request->alasan_ijin;
        $keterangan = $request->keterangan;

        // Handle foto
        if ($request->hasFile("bukti")) {
            try {
                $request->validate([
                    "bukti" => "image|mimes:jpeg,png,jpg,gif|max:5000",
                ]);

                // Format nama file: id_karyawan-tgl_pengajuan.extension
                $tgl_pengajuan = date("Ymd"); // Format tanggal: YYYYMMDD
                $extension = $request->file("bukti")->getClientOriginalExtension();
                $bukti = $id_karyawan . "-" . $tgl_pengajuan . "." . $extension;

                // Pastikan folder ada
                $uploadPath = public_path("storage/upload/bukti");
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Simpan file langsung ke public folder
                if ($request->file("bukti")->move($uploadPath, $bukti)) {
                    $data["bukti"] = $bukti;
                    // Debug: Tulis log berhasil
                    Log::info("Foto berhasil disimpan: " . $uploadPath . "/" . $bukti);
                } else {
                    // Debug: Tulis log gagal
                    Log::error("Gagal menyimpan foto ke: " . $uploadPath . "/" . $bukti);
                }
            } catch (\Exception $e) {
                // Debug: Tangkap error jika ada
                Log::error("Error saat upload foto: " . $e->getMessage());
            }
        }

        $data = [
            "id_karyawan" => $id_karyawan,
            "tgl_formulir" => $tgl_formulir,
            "status" => $status,
            "tgl_mulai" => $tgl_mulai,
            "tgl_selesai" => $tgl_selesai,
            "jenis_cuti" => $jenis_cuti,
            "lama_cuti" => $lama_cuti,
            "tgl_ijin" => $tgl_ijin,
            "jam_mulai" => $jam_mulai,
            "jam_selesai" => $jam_selesai,
            "alasan_ijin" => $alasan_ijin,
            "keterangan" => $keterangan,
            "bukti" => $bukti ?? null, // Gunakan null jika tidak ada bukti
        ];

        $simpan = DB::table("formulir")->insert($data);

        if ($simpan && $status === "Cuti") {
            return redirect("/presensi/rekapcuti")->with(["success" => "Data Berhasil Disimpan."]);
        } else {
            return redirect("/presensi/rekapijin")->with(["success" => "Data Berhasil Disimpan."]);
        }
    }

    // Di controller yang relevan, misalnya PresensiController.php
    public function detailAbsensi($id_karyawan)
    {
        $absensi = Presensi::findOrFail($id_karyawan);

        // Cek jika ada bukti foto
        if ($absensi->bukti) {
            // Jika bukti ada, persiapkan URL gambar
            $buktiUrl = asset("storage/bukti/" . $absensi->bukti);
            $buktiLink = '<a href="#" class="lihat-bukti text-primary" data-foto="' . $buktiUrl . '">Lihat</a>';
        } else {
            $buktiLink = "Tidak ada";
        }

        return view("path.to.detail_view", [
            "absensi" => $absensi,
            "buktiLink" => $buktiLink,
        ]);
    }

    public function monitoring(Request $request)
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

        return view("presensi.monitoring", compact("judul"));
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table("presensi")
            ->select("presensi.*", "nama", "department")
            ->join("karyawan", "presensi.id_karyawan", "=", "karyawan.id_karyawan")
            ->where("tgl_presensi", $tanggal)
            ->get();

        return view("presensi.getpresensi", compact("presensi"));
    }

    public function getPresensiBulanan(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = substr($bulan, 0, 4);
        $bulan = substr($bulan, 5, 2);

        $presensi = DB::table("presensi")
            ->select("presensi.*", "nama", "department")
            ->join("karyawan", "presensi.id_karyawan", "=", "karyawan.id_karyawan")
            ->whereRaw("MONTH(tgl_presensi) = ?", [$bulan])
            ->whereRaw("YEAR(tgl_presensi) = ?", [$tahun])
            ->orderBy("presensi.tgl_presensi", "asc")
            ->orderBy("karyawan.nama", "asc")
            ->get();

        return view("presensi.getpresensibulanan", compact("presensi"));
    }

    public function laporan()
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

        $karyawan = DB::table("karyawan")->orderBy("nama")->get();

        return view("presensi.laporan", compact("judul", "namabulan", "karyawan"));
    }

    public function cetaklaporan(Request $request)
    {
        $id_karyawan = $request->id_karyawan;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = [
            "",
            "JANUARI",
            "FEBRUARI",
            "MARET",
            "APRIL",
            "MEI",
            "JUNI",
            "JULI",
            "AGUSTUS",
            "SEPTEMBER",
            "OKTOBER",
            "NOVEMBER",
            "DESEMBER",
        ];
        $karyawan = DB::table("karyawan")->where("id_karyawan", $id_karyawan)->first();

        $presensi = DB::table("presensi")
            ->where("id_karyawan", $id_karyawan)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->get();

        return view("presensi.cetaklaporan", compact("namabulan", "bulan", "tahun", "karyawan", "presensi"));
    }

    public function rekaplaporan()
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

        return view("presensi.rekaplaporan", compact("judul", "namabulan"));
    }

    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $rekap = DB::table("presensi")
            ->selectRaw(
                'presensi.id_karyawan, nama, 
        MAX(IF (day(tgl_presensi) = 1, shift, NULL)) as shift_1,
        MAX(IF (day(tgl_presensi) = 2, shift, NULL)) as shift_2,
        MAX(IF (day(tgl_presensi) = 3, shift, NULL)) as shift_3,
        MAX(IF (day(tgl_presensi) = 4, shift, NULL)) as shift_4,
        MAX(IF (day(tgl_presensi) = 5, shift, NULL)) as shift_5,
        MAX(IF (day(tgl_presensi) = 6, shift, NULL)) as shift_6,
        MAX(IF (day(tgl_presensi) = 7, shift, NULL)) as shift_7,
        MAX(IF (day(tgl_presensi) = 8, shift, NULL)) as shift_8,
        MAX(IF (day(tgl_presensi) = 9, shift, NULL)) as shift_9,
        MAX(IF (day(tgl_presensi) = 10, shift, NULL)) as shift_10,
        MAX(IF (day(tgl_presensi) = 11, shift, NULL)) as shift_11,
        MAX(IF (day(tgl_presensi) = 12, shift, NULL)) as shift_12,
        MAX(IF (day(tgl_presensi) = 13, shift, NULL)) as shift_13,
        MAX(IF (day(tgl_presensi) = 14, shift, NULL)) as shift_14,
        MAX(IF (day(tgl_presensi) = 15, shift, NULL)) as shift_15,
        MAX(IF (day(tgl_presensi) = 16, shift, NULL)) as shift_16,
        MAX(IF (day(tgl_presensi) = 17, shift, NULL)) as shift_17,
        MAX(IF (day(tgl_presensi) = 18, shift, NULL)) as shift_18,
        MAX(IF (day(tgl_presensi) = 19, shift, NULL)) as shift_19,
        MAX(IF (day(tgl_presensi) = 20, shift, NULL)) as shift_20,
        MAX(IF (day(tgl_presensi) = 21, shift, NULL)) as shift_21,
        MAX(IF (day(tgl_presensi) = 22, shift, NULL)) as shift_22,
        MAX(IF (day(tgl_presensi) = 23, shift, NULL)) as shift_23,
        MAX(IF (day(tgl_presensi) = 24, shift, NULL)) as shift_24,
        MAX(IF (day(tgl_presensi) = 25, shift, NULL)) as shift_25,
        MAX(IF (day(tgl_presensi) = 26, shift, NULL)) as shift_26,
        MAX(IF (day(tgl_presensi) = 27, shift, NULL)) as shift_27,
        MAX(IF (day(tgl_presensi) = 28, shift, NULL)) as shift_28,
        MAX(IF (day(tgl_presensi) = 29, shift, NULL)) as shift_29,
        MAX(IF (day(tgl_presensi) = 30, shift, NULL)) as shift_30,
        MAX(IF (day(tgl_presensi) = 31, shift, NULL)) as shift_31,
        MAX(IF (day(tgl_presensi) = 1, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_1,
        MAX(IF (day(tgl_presensi) = 2, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_2,
        MAX(IF (day(tgl_presensi) = 3, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_3,
        MAX(IF (day(tgl_presensi) = 4, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_4,
        MAX(IF (day(tgl_presensi) = 5, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_5,
        MAX(IF (day(tgl_presensi) = 6, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_6,
        MAX(IF (day(tgl_presensi) = 7, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_7,
        MAX(IF (day(tgl_presensi) = 8, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_8,
        MAX(IF (day(tgl_presensi) = 9, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_9,
        MAX(IF (day(tgl_presensi) = 10, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_10,
        MAX(IF (day(tgl_presensi) = 11, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_11,
        MAX(IF (day(tgl_presensi) = 12, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_12,
        MAX(IF (day(tgl_presensi) = 13, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_13,
        MAX(IF (day(tgl_presensi) = 14, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_14,
        MAX(IF (day(tgl_presensi) = 15, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_15,
        MAX(IF (day(tgl_presensi) = 16, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_16,
        MAX(IF (day(tgl_presensi) = 17, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_17,
        MAX(IF (day(tgl_presensi) = 18, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_18,
        MAX(IF (day(tgl_presensi) = 19, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_19,
        MAX(IF (day(tgl_presensi) = 20, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_20,
        MAX(IF (day(tgl_presensi) = 21, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_21,
        MAX(IF (day(tgl_presensi) = 22, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_22,
        MAX(IF (day(tgl_presensi) = 23, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_23,
        MAX(IF (day(tgl_presensi) = 24, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_24,
        MAX(IF (day(tgl_presensi) = 25, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_25,
        MAX(IF (day(tgl_presensi) = 26, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_26,
        MAX(IF (day(tgl_presensi) = 27, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_27,
        MAX(IF (day(tgl_presensi) = 28, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_28,
        MAX(IF (day(tgl_presensi) = 29, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_29,
        MAX(IF (day(tgl_presensi) = 30, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_30,
        MAX(IF (day(tgl_presensi) = 31, concat(jam_in," - ",IFnull(jam_out,"NULL")), "")) as tgl_31',
            )
            ->join("karyawan", "presensi.id_karyawan", "=", "karyawan.id_karyawan")
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->groupByRaw("presensi.id_karyawan, nama")
            ->get();

        $namabulan = [
            "",
            "JANUARI",
            "FEBRUARI",
            "MARET",
            "APRIL",
            "MEI",
            "JUNI",
            "JULI",
            "AGUSTUS",
            "SEPTEMBER",
            "OKTOBER",
            "NOVEMBER",
            "DESEMBER",
        ];
        return view("presensi.cetakrekap", compact("namabulan", "rekap", "bulan", "tahun"));
    }

    public function cari(Request $request)
    {
        $keyword = $request->cari;
        $tanggal = $request->tanggal ?? date("Y-m-d"); // Default ke hari ini jika tidak ada
        $bulan = $request->bulan ?? date("Y-m"); // Default ke bulan ini jika tidak ada
        $filter_type = $request->filter_type ?? "harian"; // Default ke harian jika tidak ada

        // Base query dengan join untuk mendapatkan nama dan department
        $query = DB::table("presensi")
            ->join("karyawan", "presensi.id_karyawan", "=", "karyawan.id_karyawan")
            ->select("presensi.*", "karyawan.nama", "karyawan.department");

        // Terapkan filter berdasarkan jenis filter (harian/bulanan)
        if ($filter_type == "harian") {
            $query->whereRaw("DATE(tgl_presensi) = ?", [$tanggal]);
        } else {
            $query->whereRaw('DATE_FORMAT(tgl_presensi, "%Y-%m") = ?', [$bulan]);
        }

        // Terapkan keyword pencarian jika ada
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where("presensi.id_karyawan", "like", "%" . $keyword . "%")
                    ->orWhere("karyawan.nama", "like", "%" . $keyword . "%")
                    ->orWhere("karyawan.department", "like", "%" . $keyword . "%")
                    ->orWhere("presensi.shift", "like", "%" . $keyword . "%");
            });
        }

        $presensi = $query->get();

        return response()->json($presensi);
    }

    public function dataijin(Request $request)
    {
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

        $query = Formulir::query();
        $query->select(
            "id_formulir",
            "formulir.id_karyawan",
            "nama",
            "department",
            "tgl_formulir",
            "tgl_ijin",
            "jam_mulai",
            "jam_selesai",
            "alasan_ijin",
            "status_approved",
            "keterangan",
            "bukti",
        );
        $query->where("status", "Ijin");
        $query->join("karyawan", "formulir.id_karyawan", "=", "karyawan.id_karyawan");
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween("tgl_ijin", [$request->dari, $request->sampai]);
        }

        if (!empty($request->id_karyawan)) {
            $query->where("formulir.id_karyawan", $request->id_karyawan);
        }

        if (!empty($request->nama)) {
            $query->where("nama", "like", "%" . $request->nama . "%");
        }

        if (
            $request->status_approved === "0" ||
            $request->status_approved === "1" ||
            $request->status_approved === "2"
        ) {
            $query->where("status_approved", $request->status_approved);
        }

        $query->orderBy("tgl_formulir", "desc");
        $ijin = $query->paginate(10);
        $ijin->appends($request->all());

        return view("presensi.dataijin", compact("judul", "ijin"));
    }

    public function datacuti(Request $request)
    {
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

        $query = Formulir::query();
        $query->select(
            "id_formulir",
            "formulir.id_karyawan",
            "nama",
            "department",
            "tgl_formulir",
            "tgl_mulai",
            "tgl_selesai",
            "lama_cuti",
            "jenis_cuti",
            "status_approved",
            "keterangan",
            "bukti",
        );
        $query->where("status", "Cuti");
        $query->join("karyawan", "formulir.id_karyawan", "=", "karyawan.id_karyawan");
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween("tgl_mulai", [$request->dari, $request->sampai]);
        }

        if (!empty($request->id_karyawan)) {
            $query->where("formulir.id_karyawan", $request->id_karyawan);
        }

        if (!empty($request->nama)) {
            $query->where("nama", "like", "%" . $request->nama . "%");
        }

        if (
            $request->status_approved === "0" ||
            $request->status_approved === "1" ||
            $request->status_approved === "2"
        ) {
            $query->where("status_approved", $request->status_approved);
        }

        $query->orderBy("tgl_formulir", "desc");
        $cuti = $query->paginate(10);
        $cuti->appends($request->all());

        return view("presensi.datacuti", compact("judul", "cuti"));
    }

    public function approvedcuti(Request $request)
    {
        $status_approved = $request->status_approved;
        $alasan_penolakan = $request->alasan_penolakan;
        $id_cuti_formulir = $request->id_cuti_formulir;
        $update = DB::table("formulir")
            ->where("id_formulir", $id_cuti_formulir)
            ->update([
                "status_approved" => $status_approved,
                "alasan_penolakan" => $alasan_penolakan,
            ]);

        if ($update) {
            return Redirect::back()->with("success", "Status Berhasil Di Update");
        } else {
            return Redirect::back()->with("warning", "Status Gagal Di Update");
        }
    }

    public function approvedijin(Request $request)
    {
        $status_approved = $request->status_approved;
        $alasan_penolakan = $request->alasan_penolakan;
        $id_ijin_formulir = $request->id_ijin_formulir;
        $update = DB::table("formulir")
            ->where("id_formulir", $id_ijin_formulir)
            ->update([
                "status_approved" => $status_approved,
                "alasan_penolakan" => $alasan_penolakan,
            ]);

        if ($update) {
            return Redirect::back()->with("success", "Status Berhasil Di Update");
        } else {
            return Redirect::back()->with("warning", "Status Gagal Di Update");
        }
    }

    public function batalstatus($id_formulir)
    {
        $update = DB::table("formulir")
            ->where("id_formulir", $id_formulir)
            ->update([
                "status_approved" => 0,
            ]);

        if ($update) {
            return Redirect::back()->with(["success", "Status Berhasil Di Update"]);
        } else {
            return Redirect::back()->with(["warning", "Status Gagal Di Update"]);
        }
    }

    public function cekpengajuanijin(Request $request)
    {
        $tgl_ijin = $request->tgl_ijin;

        // Perbaikan 1: Konsisten menggunakan guard
        $id_karyawan = Auth::user("karyawan")->id_karyawan;

        $cek = DB::table("formulir")->where("id_karyawan", $id_karyawan)->where("tgl_ijin", $tgl_ijin)->count();

        return $cek;
    }

    public function cekpengajuancuti(Request $request)
    {
        $tgl_mulai = $request->tgl_mulai;
        $id_karyawan = Auth::user("karyawan")->id_karyawan;

        Log::info("DEBUG CUTI", [
            "tgl_mulai" => $tgl_mulai,
            "id_karyawan" => $id_karyawan,
        ]);

        $cek = DB::table("formulir")->where("id_karyawan", $id_karyawan)->where("tgl_mulai", $tgl_mulai)->count();

        Log::info("Jumlah data cuti ditemukan:", ["count" => $cek]);

        return response()->json([
            "count" => $cek,
        ]);
    }
}

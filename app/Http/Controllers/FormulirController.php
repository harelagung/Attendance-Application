<?php

namespace App\Http\Controllers;

use App\Models\Formulir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FormulirController extends Controller
{
    public function editcuti($id_formulir)
    {
        $formulir = DB::table("formulir")->where("id_formulir", $id_formulir)->first();

        return view("formulir.editcuti", compact("formulir"));
    }

    public function editijin($id_formulir)
    {
        // dd([
        //     "Parameter dari URL" => $id_formulir,
        //     "Type parameter" => gettype($id_formulir),
        //     "URL lengkap" => request()->fullUrl(),
        // ]);
        $formulir = DB::table("formulir")->where("id_formulir", $id_formulir)->first();

        return view("formulir.editijin", compact("formulir"));
    }

    public function updatecuti(Request $request, $id_formulir)
    {
        $formulir = DB::table("formulir")->where("id_formulir", $id_formulir)->first();

        $id_karyawan = Auth::user()->id_karyawan;
        $tgl_formulir = date("Y-m-d");
        $status = $request->status;
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;
        $jenis_cuti = $request->jenis_cuti;
        $lama_cuti = $request->lama_cuti;
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
            "id_formulir" => $request->id_formulir,
            "id_karyawan" => $id_karyawan,
            "tgl_formulir" => $tgl_formulir,
            "status" => $status,
            "tgl_mulai" => $tgl_mulai,
            "tgl_selesai" => $tgl_selesai,
            "lama_cuti" => $lama_cuti,
            "jenis_cuti" => $jenis_cuti,
            "keterangan" => $keterangan,
            "bukti" => $bukti ?? null,
            "status_approved" => 0,
        ];

        // Update data di database
        $update = DB::table("formulir")->where("id_formulir", $id_formulir)->update($data);

        return redirect("/presensi/rekapcuti")->with(["success" => "Data berhasil di update"]);
    }

    public function updateijin(Request $request, $id_formulir)
    {
        $formulir = DB::table("formulir")->where("id_formulir", $id_formulir)->first();

        $id_karyawan = Auth::user()->id_karyawan;
        $tgl_formulir = date("Y-m-d");
        $status = $request->status;
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
            "id_formulir" => $request->id_formulir,
            "id_karyawan" => $id_karyawan,
            "tgl_formulir" => $tgl_formulir,
            "status" => $status,
            "tgl_ijin" => $tgl_ijin,
            "jam_mulai" => $jam_mulai,
            "jam_selesai" => $jam_selesai,
            "alasan_ijin" => $alasan_ijin,
            "keterangan" => $keterangan,
            "bukti" => $bukti ?? null,
            "status_approved" => 0,
        ];

        // Update data di database
        $update = DB::table("formulir")->where("id_formulir", $id_formulir)->update($data);

        return redirect("/presensi/rekapijin")->with(["success" => "Data berhasil di update"]);
    }

    public function deletecuti($id_formulir)
    {
        try {
            // ✅ PERBAIKAN: Pastikan menggunakan nama kolom yang benar
            $formulir = DB::table("formulir")->where("id_formulir", $id_formulir)->first();

            if (!$formulir) {
                return redirect()->back()->with("error", "Data tidak ditemukan");
            }

            // Hapus file bukti jika ada
            if ($formulir->bukti) {
                $filePath = public_path("storage/upload/bukti/" . $formulir->bukti);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus data dari database
            $delete = DB::table("formulir")->where("id_formulir", $id_formulir)->delete();

            if ($delete) {
                return redirect()->back()->with("success", "Data berhasil dihapus");
            } else {
                return redirect()->back()->with("error", "Gagal menghapus data");
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with("error", "Error: " . $e->getMessage());
        }
    }

    public function deleteijin($id_formulir)
    {
        try {
            // ✅ PERBAIKAN: Pastikan menggunakan nama kolom yang benar
            $formulir = DB::table("formulir")->where("id_formulir", $id_formulir)->first();

            if (!$formulir) {
                return redirect()->back()->with("error", "Data tidak ditemukan");
            }

            // Hapus file bukti jika ada
            if ($formulir->bukti) {
                $filePath = public_path("storage/upload/bukti/" . $formulir->bukti);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Hapus data dari database
            $delete = DB::table("formulir")->where("id_formulir", $id_formulir)->delete();

            if ($delete) {
                return redirect()->back()->with("success", "Data berhasil dihapus");
            } else {
                return redirect()->back()->with("error", "Gagal menghapus data");
            }
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with("error", "Error: " . $e->getMessage());
        }
    }

    public function tambahcuti()
    {
        return view("formulir.tambahcuti");
    }

    public function tambahijin()
    {
        return view("formulir.tambahijin");
    }

    public function storecuti(Request $request)
    {
        $id_karyawan = Auth::user()->id_karyawan;
        $tgl_formulir = date("Y-m-d");
        $status = $request->status;
        $tgl_mulai = $request->tgl_mulai;
        $tgl_selesai = $request->tgl_selesai;
        $jenis_cuti = $request->jenis_cuti;
        $lama_cuti = $request->lama_cuti;
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
            "keterangan" => $keterangan,
            "bukti" => $bukti ?? null, // Gunakan null jika tidak ada bukti
        ];

        $simpan = DB::table("formulir")->insert($data);

        return redirect("/presensi/rekapcuti")->with(["success" => "Data Berhasil Disimpan."]);
    }

    public function storeijin(Request $request)
    {
        $id_karyawan = Auth::user()->id_karyawan;
        $tgl_formulir = date("Y-m-d");
        $status = $request->status;
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
            "tgl_ijin" => $tgl_ijin,
            "jam_mulai" => $jam_mulai,
            "jam_selesai" => $jam_selesai,
            "alasan_ijin" => $alasan_ijin,
            "keterangan" => $keterangan,
            "bukti" => $bukti ?? null, // Gunakan null jika tidak ada bukti
        ];

        $simpan = DB::table("formulir")->insert($data);

        return redirect("/presensi/rekapijin")->with(["success" => "Data Berhasil Disimpan."]);
    }
}

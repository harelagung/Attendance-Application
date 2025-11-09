<?php

namespace App\Http\Controllers;
use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    function tampil(Request $request)
    {
        $query = Absensi::query();

        // Filter pencarian multi kolom
        if (!empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where("nama", "like", "%" . $keyword . "%")
                    ->orWhere("id_karyawan", "like", "%" . $keyword . "%")
                    ->orWhere("jabatan", "like", "%" . $keyword . "%")
                    ->orWhere("department", "like", "%" . $keyword . "%")
                    ->orWhere("jenkel", "like", "%" . $keyword . "%")
                    ->orWhere("alamat", "like", "%" . $keyword . "%")
                    ->orWhere("no_hp", "like", "%" . $keyword . "%")
                    ->orWhere("status_perkawinan", "like", "%" . $keyword . "%")
                    ->orWhere("status_pekerja", "like", "%" . $keyword . "%")
                    ->orWhere("join", "like", "%" . $keyword . "%")
                    ->orWhere("end", "like", "%" . $keyword . "%");
            });
        }

        // Filter berdasarkan department jika ada input
        if (!empty($request->department)) {
            $query->where("department", $request->department);
        }

        $query->orderBy("nama");
        $karyawan = $query->paginate(20);
        $karyawan->appends($request->all());

        // Ambil daftar department yang unik
        $department = DB::table("karyawan")->select("department")->distinct()->get();
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

        return view("absen.tampil", compact("karyawan", "department", "judul"));
    }

    function tambah()
    {
        return view("absen.tambah");
    }

    function submit(Request $request)
    {
        $karyawan = new Absensi();

        // Siapkan data submit
        $data = [
            "id_karyawan" => $request->id_karyawan,
            "nama" => $request->nama,
            "jenkel" => $request->jenkel,
            "alamat" => $request->alamat,
            "no_hp" => $request->no_hp,
            "department" => $request->department,
            "jabatan" => $request->jabatan,
            "status_perkawinan" => $request->status_perkawinan,
            "status_pekerja" => $request->status_pekerja,
            "join" => $request->join,
            "end" => $request->end,
        ];

        // Handle foto
        if ($request->hasFile("foto")) {
            try {
                $request->validate([
                    "foto" => "image|mimes:jpeg,png,jpg,gif|max:5000",
                ]);

                $foto = $request->id_karyawan . "." . $request->file("foto")->getClientOriginalExtension();

                // Pastikan folder ada
                $uploadPath = public_path("storage/upload/foto_karyawan");
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Simpan file langsung ke public folder
                if ($request->file("foto")->move($uploadPath, $foto)) {
                    $data["foto"] = $foto;
                    // Debug: Tulis log berhasil
                    Log::info("Foto berhasil disimpan: " . $uploadPath . "/" . $foto);
                } else {
                    // Debug: Tulis log gagal
                    Log::error("Gagal menyimpan foto ke: " . $uploadPath . "/" . $foto);
                }
            } catch (\Exception $e) {
                // Debug: Tangkap error jika ada
                Log::error("Error saat upload foto: " . $e->getMessage());
            }
        }

        // Simpan data di database
        $data["nama"] = ucwords($data["nama"]); // Ubah format nama sebelum simpan
        $simpan = DB::table("karyawan")->insert($data);

        if ($simpan || $request->hasFile("foto")) {
            return redirect()
                ->route("absen.tampil")
                ->with(["success" => "Data Berhasil di Simpan"]);
        } else {
            return redirect()
                ->route("absen.tampil")
                ->with(["error" => "Data Gagal di Simpan"]);
        }
    }

    public function edit($id_karyawan)
    {
        $karyawan = DB::table("karyawan")->where("id_karyawan", $id_karyawan)->first();
        return view("absen.edit", compact("karyawan"));
    }

    function update(Request $request, $id_karyawan)
    {
        $karyawan = DB::table("karyawan")->where("id_karyawan", $id_karyawan)->first();

        if (!$karyawan) {
            return Redirect::back()->with(["error" => "Data Karyawan tidak ditemukan"]);
        }

        // Siapkan data update
        $data = [
            "id_karyawan" => $request->id_karyawan,
            "nama" => $request->nama,
            "jenkel" => $request->jenkel,
            "alamat" => $request->alamat,
            "no_hp" => $request->no_hp,
            "department" => $request->department,
            "jabatan" => $request->jabatan,
            "status_perkawinan" => $request->status_perkawinan,
            "status_pekerja" => $request->status_pekerja,
            "join" => $request->join,
            "end" => $request->end,
        ];

        // Handle foto
        if ($request->hasFile("foto")) {
            try {
                $request->validate([
                    "foto" => "image|mimes:jpeg,png,jpg,gif|max:5000",
                ]);

                $foto = $request->id_karyawan . "." . $request->file("foto")->getClientOriginalExtension();

                // Pastikan folder ada
                $uploadPath = public_path("storage/upload/foto_karyawan");
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Simpan file langsung ke public folder
                if ($request->file("foto")->move($uploadPath, $foto)) {
                    $data["foto"] = $foto;
                    // Debug: Tulis log berhasil
                    Log::info("Foto berhasil disimpan: " . $uploadPath . "/" . $foto);
                } else {
                    // Debug: Tulis log gagal
                    Log::error("Gagal menyimpan foto ke: " . $uploadPath . "/" . $foto);
                }
            } catch (\Exception $e) {
                // Debug: Tangkap error jika ada
                Log::error("Error saat upload foto: " . $e->getMessage());
            }
        }

        // Update data di database
        $data["nama"] = ucwords($data["nama"]); // Ubah format nama sebelum simpan
        $update = DB::table("karyawan")->where("id_karyawan", $id_karyawan)->update($data);

        if ($update || $request->hasFile("foto")) {
            return redirect()
                ->route("absen.tampil")
                ->with(["success" => "Data Berhasil di Update"]);
        } else {
            return Redirect::back()->with(["error" => "Data Gagal di Update"]);
        }
    }

    function showLoginForm()
    {
        return view("login");
    }

    function login(Request $request)
    {
        $credentials = $request->validate([
            "id_karyawan" => "required",
            "password" => "required",
        ]);

        $karyawan = Karyawan::where("id_karyawan", $credentials["id_karyawan"])->first();

        if ($karyawan && Hash::check($credentials["password"], $karyawan->password)) {
            // Login berhasil
            Auth::login($karyawan);

            if ($karyawan->jabatan === "Admin") {
                return redirect()->route("dashboard.dashboardadmin");
            } else {
                return redirect()->route("dashboard");
            }
        }

        // Login gagal
        return back()->with("error", "ID Karyawan atau Password salah!")->withInput($request->except("password"));
    }

    function logout()
    {
        Auth::logout();
        return redirect("login");
    }

    public function logoutRedirect()
    {
        Auth::logout();
        return redirect("login");
    }

    function tampilProfil()
    {
        return view("profil.tampil");
    }

    // Di KaryawanController.php
    public function resetPassword($id_karyawan)
    {
        $karyawan = Karyawan::findOrFail($id_karyawan);

        // Reset password ke default (12345678)
        $karyawan->password = Hash::make("12345678");
        $karyawan->save();

        return redirect()->route("absen.tampil")->with("success", "Password berhasil direset");
    }

    function delete($id_karyawan)
    {
        $karyawan = Absensi::find($id_karyawan);
        $karyawan->delete();
        return redirect()->route("absen.tampil");
    }
}

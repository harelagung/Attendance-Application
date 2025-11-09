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
    function tampil()
    {
        $karyawan = Absensi::select("*")->get();
        return view("absen.tampil", compact("karyawan"));
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

    function delete($id_karyawan)
    {
        $karyawan = Absensi::find($id_karyawan);
        $karyawan->delete();
        return redirect()->route("absen.tampil");
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
            return redirect()->route("dashboard");
        }

        // Login gagal
        return back()->with("error", "ID Karyawan atau Password salah!")->withInput($request->except("password"));
    }

    function logout()
    {
        Auth::logout();
        return redirect("login");
    }

    function tampilProfil()
    {
        return view("profil.tampil");
    }
}

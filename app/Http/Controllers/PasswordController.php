<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;

class PasswordController extends Controller
{
    function changePassword()
    {
        return view("profil.change-password");
    }

    function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate(
            [
                "new_password" => "required|string|size:8",
                "confirm_password" => "required|same:new_password",
            ],
            [
                "new_password.required" => "Password baru harus diisi",
                "new_password.size" => "Password harus 8 karakter",
                "confirm_password.required" => "Konfirmasi password harus diisi",
                "confirm_password.same" => "Konfirmasi password tidak cocok",
            ],
        );

        try {
            // Update password
            $karyawan = Karyawan::find(Auth::user()->id_karyawan);
            $karyawan->password = Hash::make($request->new_password);
            $karyawan->save();

            return redirect()->route("profil.tampil")->with("success", "Password berhasil diubah");
        } catch (\Exception $e) {
            return redirect()->back()->with("error", "Gagal mengubah password");
        }
    }
}

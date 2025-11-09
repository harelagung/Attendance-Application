<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormulirController;
use App\Http\Controllers\KonfigurasiController;
use App\Models\Absensi;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get("/", function () {
    return view("login");
});

Route::get("/login", function () {
    return view("login");
})->name("login");

Route::get("/dashboard", [DashboardController::class, "index"])
    ->middleware("auth")
    ->name("dashboard");

Route::post("/login/attempt", [AbsensiController::class, "login"])->name("login.attempt");

Route::middleware(["auth", "admin"])->group(function () {
    Route::get("/dashboard/dashboardadmin", [DashboardController::class, "dashboardadmin"])->name(
        "dashboard.dashboardadmin",
    );
    Route::get("/absen", [AbsensiController::class, "tampil"])->name("absen.tampil");
    Route::get("/absen/search", [AbsensiController::class, "search"])->name("absen.search");
    Route::get("/absen/tambah", [AbsensiController::class, "tambah"])->name("absen.tambah");
    Route::post("/absen/submit", [AbsensiController::class, "submit"])->name("absen.submit");
    Route::get("/absen/edit/{id_karyawan}", [AbsensiController::class, "edit"])->name("absen.edit");
    Route::post("/absen/update/{id_karyawan}", [AbsensiController::class, "update"])->name("absen.update");
    Route::post("/absen/delete/{id_karyawan}", [AbsensiController::class, "delete"])->name("absen.delete");
    Route::post("/absen/{id_karyawan}/reset-password", [AbsensiController::class, "resetPassword"])->name(
        "reset-password",
    );
    Route::get("/absen/detail/{karyawan}", [AbsensiController::class, "detail"])->name("absen.detail");

    // Presensi
    Route::get("/presensi/monitoring", [PresensiController::class, "monitoring"])->name("presensi.monitoring");
    Route::post("/getpresensi", [PresensiController::class, "getpresensi"]);
    Route::post("/getpresensibulanan", [PresensiController::class, "getPresensiBulanan"])->name("getpresensibulanan");
    Route::get("/presensi/laporan", [PresensiController::class, "laporan"]);
    Route::post("/presensi/cetaklaporan", [PresensiController::class, "cetaklaporan"]);
    Route::get("/presensi/rekaplaporan", [PresensiController::class, "rekaplaporan"]);
    Route::post("/presensi/cetakrekap", [PresensiController::class, "cetakrekap"]);
    Route::get("/presensi/dataijin", [PresensiController::class, "dataijin"])->name("dataijin");
    Route::get("/presensi/datacuti", [PresensiController::class, "datacuti"])->name("datacuti");
    Route::post("/presensi/approvedcuti", [PresensiController::class, "approvedcuti"]);
    Route::get("/presensi/{id_formulir}/batalstatus", [PresensiController::class, "batalstatus"]);
    Route::post("/presensi/approvedijin", [PresensiController::class, "approvedijin"]);
    Route::get("/presensi/{id_formulir}/batalstatus", [PresensiController::class, "batalstatus"]);

    // Konfigurasi
    Route::get("/konfigurasi/lokasi_kantor", [KonfigurasiController::class, "lokasikantor"]);
    Route::post("/konfigurasi/updatelokasi_kantor", [KonfigurasiController::class, "updatelokasikantor"]);

    // Search
    Route::get("/cari", [PresensiController::class, "cari"])->name("cari");
});

Route::middleware("auth")->group(function () {
    Route::get("/profil", [AbsensiController::class, "tampilProfil"])
        ->name("profil.tampil")
        ->middleware("auth");
    Route::get("/profil/change-password", [PasswordController::class, "changePassword"])->name(
        "profil.change-password",
    );
    Route::post("/profil/update-password", [PasswordController::class, "updatePassword"])->name(
        "profil.update-password",
    );
    Route::post("/logout", [AbsensiController::class, "logout"])->name("logout");
    Route::get("/logout", [AbsensiController::class, "logoutRedirect"])->name("logout.redirect");

    //Presensi
    Route::get("/presensi/create", [PresensiController::class, "create"]);
    Route::post("/presensi/store", [PresensiController::class, "store"]);

    // History
    Route::get("/presensi/history", [PresensiController::class, "history"]);
    Route::post("/gethistory", [PresensiController::class, "gethistory"]);

    // Izin
    Route::get("/presensi/rekapcuti", [PresensiController::class, "rekapcuti"]);
    Route::get("/presensi/rekapijin", [PresensiController::class, "rekapijin"]);
    Route::get("/presensi/formulir", [PresensiController::class, "formulir"])->name("formulir");
    Route::post("/presensi/storeformulir", [PresensiController::class, "storeformulir"]);

    Route::post("/presensi/cekpengajuancuti", [PresensiController::class, "cekpengajuancuti"]);
    Route::post("/presensi/cekpengajuanijin", [PresensiController::class, "cekpengajuanijin"]);

    // Konfigurasi Form Cuti Karyawan
    Route::get("/formulir/editcuti/{id_formulir}", [FormulirController::class, "editcuti"])->name("formulir.editcuti");
    Route::post("/formulir/updatecuti/{id_formulir}", [FormulirController::class, "updatecuti"])->name("update.cuti");
    Route::post("/formulir/deletecuti/{id_formulir}", [FormulirController::class, "deletecuti"])->name("delete.cuti");
    Route::get("/formulir/tambahcuti", [FormulirController::class, "tambahcuti"])->name("tambah.cuti");
    Route::post("/formulir/storecuti", [FormulirController::class, "storecuti"])->name("store.cuti");

    // Konfigurasi Form Ijin Karyawan
    Route::get("/formulir/editijin/{id_formulir}", [FormulirController::class, "editijin"]);
    Route::post("/formulir/updateijin/{id_formulir}", [FormulirController::class, "updateijin"])->name("update.ijin");
    Route::post("/formulir/deleteijin/{id_formulir}", [FormulirController::class, "deleteijin"])->name("delete.ijin");
    Route::get("/formulir/tambahijin", [FormulirController::class, "tambahijin"])->name("tambah.ijin");
    Route::post("/formulir/storeijin", [FormulirController::class, "storeijin"])->name("store.ijin");
});

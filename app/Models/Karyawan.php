<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Karyawan extends Authenticatable
{
    protected $table = "karyawan";
    protected $primaryKey = "id_karyawan";

    protected $fillable = [
        "foto",
        "id_karyawan",
        "nama",
        "jenkel",
        "alamat",
        "no_hp",
        "department",
        "jabatan",
        "status_perkawinan",
        "status_pekerja",
        "join",
        "end",
        "password",
    ];

    // password di-hash
    protected $hidden = ["password"];

    public function presensi()
    {
        return $this->hasMany(Presensi::class, "id_karyawan", "id_karyawan");
    }
}

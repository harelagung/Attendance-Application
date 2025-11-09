<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    protected $table = "presensi";
    // app/Models/Presensi.php
    protected $fillable = [
        "id_karyawan",
        "tgl_presensi",
        "jam_in",
        "jam_out",
        "foto_in",
        "foto_out",
        "lokasi_in",
        "lokasi_out",
        "shift",
    ];
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, "id_karyawan", "id_karyawan");
    }
}

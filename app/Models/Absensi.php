<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = "karyawan";
    protected $primaryKey = "id_karyawan";
    protected $fillable = [
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
    ];

    public function setNamaAttribute($value)
    {
        $this->attributes["nama"] = ucwords($value);
    }
}

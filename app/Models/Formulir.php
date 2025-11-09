<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    use HasFactory;
    protected $table = "formulir";
    protected $fillable = [
        "id_formulir",
        "id_karyawan",
        "tgl_formulir",
        "status",
        "tgl_mulai",
        "tgl_selesai",
        "lama_cuti",
        "jenis_cuti",
        "tgl_ijin",
        "jam_mulai",
        "jam_selesai",
        "alasan_ijin",
        "keterangan",
        "bukti",
        "status_approved",
    ];
}

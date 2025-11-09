<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('karyawan')->insert([
            'id_karyawan' => 10011001, // Sesuaikan dengan format ID karyawan Anda
            'nama' => 'Admin',
            'jenkel' => 'Laki-Laki',
            'alamat' => 'Alamat Admin',
            'no_hp' => '081234567890',
            'department' => 'HR',
            'jabatan' => 'Admin',
            'status_perkawinan' => 'Lajang',
            'status_pekerja' => 'Tetap',
            'join' => Carbon::now()->format('Y-m-d'),
            'end' => Carbon::now()->addYears(10)->format('Y-m-d'),
            'password' => Hash::make('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}

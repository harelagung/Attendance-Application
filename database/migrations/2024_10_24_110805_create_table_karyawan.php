<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->integer('id_karyawan')->primary();
            $table->varchar('foto');
            $table->string('nama', 100);
            $table->enum('jenkel', ['Laki-Laki', 'Perempuan']);
            $table->text('alamat');
            $table->string('no_hp', 15);
            $table->enum('department', ['Quality Control','Production Control','Painting', 'Casting', 'Machining', 'HR', 'Engineering', 'Finance']);
            $table->enum('jabatan', ['Admin', 'Staff', 'Operator', 'Leader', 'Foreman', 'Supervisor', 'Assistant Manager', 'Manager']);
            $table->enum('status_perkawinan', ['Lajang', 'Menikah', 'Bercerai']);
            $table->enum('status_pekerja', ['Kontrak', 'Tetap']);
            $table->date('join');
            $table->date('end');
            $table->string('password')->default(Hash::make('12345678'));
            $table->timestamps();
        });

        // Schema::create('absensi', function (Blueprint $table) {
        //     $table->id('id_absensi'); // Primary key dengan auto increment
        //     $table->integer('id_karyawan')->index(); // Kolom id_karyawan dengan index
        //     $table->timestamp('masuk')->useCurrent(); // Default CURRENT_TIMESTAMP
        //     $table->timestamp('keluar')->nullable()->default(null)->useCurrentOnUpdate(); // Timestamp dengan on update

        //     // Definisi foreign key yang menghubungkan ke tabel karyawan
        //     $table->foreign('id_karyawan')
        //           ->references('id_karyawan')
        //           ->on('karyawan')
        //           ->onDelete('cascade'); // Jika karyawan dihapus, absensi yang terkait juga dihapus
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};

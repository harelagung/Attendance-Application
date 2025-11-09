<?php

namespace Database\Seeders;

use App\Models\Presensi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UpdateShiftDataSeeder extends Seeder
{
    public function run()
    {
        $presensiList = Presensi::all();
        
        foreach ($presensiList as $presensi) {
            $jamIn = Carbon::parse($presensi->jam_in);
            
            if ($jamIn->between(Carbon::parse('03:00:00'), Carbon::parse('16:00:00'))) {
                $presensi->shift = 1;
            } else {
                $presensi->shift = 2;
            }
            
            $presensi->save();
        }
        
        $this->command->info("Shift data updated for " . $presensiList->count() . " records.");
    }
}
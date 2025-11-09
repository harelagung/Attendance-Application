<?php

namespace App\Observers;

use Carbon\Carbon;
use App\Models\Presensi;
use Illuminate\Support\Facades\Log;

class PresensiObserver
{
    /**
     * Handle the Presensi "created" event.
     */
    public function created(Presensi $presensi): void
    {
    info('Presensi created: ' . json_encode($presensi->toArray()));
    
    if (!$presensi->jam_in) {
        info('Jam_in kosong');
        return;
    }
    
    try {
        $jamIn = Carbon::parse($presensi->jam_in);
        info('Jam Parse: ' . $jamIn->format('H:i:s'));
        
        // Tentukan batas waktu dalam format yang sama
        $awal = Carbon::parse('03:00:00');
        $akhir = Carbon::parse('16:00:00');
        
        info("Awal: {$awal->format('H:i:s')}, Akhir: {$akhir->format('H:i:s')}");
        info("Between check: " . ($jamIn->between($awal, $akhir) ? 'true' : 'false'));
        
        if ($jamIn->between($awal, $akhir)) {
            info('Set shift 1');
            $presensi->shift = 1;
        } else {
            info('Set shift 2');
            $presensi->shift = 2;
        }
        
        // Simpan perubahan
        $result = $presensi->save();
        info('Save result: ' . ($result ? 'success' : 'failed'));
    } catch (\Exception $e) {
        info('Error: ' . $e->getMessage());
    }
    }

    /**
     * Handle the Presensi "updated" event.
     */
    public function updated(Presensi $presensi): void
    {
        //
    }

    /**
     * Handle the Presensi "deleted" event.
     */
    public function deleted(Presensi $presensi): void
    {
        //
    }

    /**
     * Handle the Presensi "restored" event.
     */
    public function restored(Presensi $presensi): void
    {
        //
    }

    /**
     * Handle the Presensi "force deleted" event.
     */
    public function forceDeleted(Presensi $presensi): void
    {
        //
    }
}

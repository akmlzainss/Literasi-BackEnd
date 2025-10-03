<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Penghargaan;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            // Panggil reset untuk bulan lalu
            $monthToArchive = now()->subMonth()->format('Y-m');
            Penghargaan::where('bulan_tahun', 'like', $monthToArchive . '%')
                ->where('arsip', false)
                ->update(['arsip' => true]);
            // Log atau notif jika perlu
        })->monthlyOn(1, '0:00'); // Tanggal 1 jam 00:00 setiap bulan
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

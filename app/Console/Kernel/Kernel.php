<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * 定期実行コマンドの登録
     */
    protected function schedule(Schedule $schedule)
    {
        // 毎日午前0時にToDoチェック
        $schedule->command('tasks:check-deadlines')->daily();
    }

    /**
     * artisan コマンドの登録
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

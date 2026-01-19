<?php

namespace App\Console;

use App\Console\Commands\BackupDatabase;
use App\Console\Commands\CreateAdmin;
use App\Console\Commands\PruneBackups;
use App\Console\Commands\RestoreDatabase;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        BackupDatabase::class,
        CreateAdmin::class,
        PruneBackups::class,
        RestoreDatabase::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:backup-db')->weekly()->sundays()->at('03:00');
        $schedule->command('app:prune-backups')->daily()->at('04:00');
    }
}

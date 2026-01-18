<?php

namespace App\Console;

<<<<<<< HEAD
use App\Console\Commands\BackupDatabase;
use App\Console\Commands\CreateAdmin;
use App\Console\Commands\PruneBackups;
use App\Console\Commands\RestoreDatabase;
=======
use App\Console\Commands\CreateAdmin;
>>>>>>> origin/main
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
<<<<<<< HEAD
        BackupDatabase::class,
        CreateAdmin::class,
        PruneBackups::class,
        RestoreDatabase::class,
=======
        CreateAdmin::class,
>>>>>>> origin/main
    ];

    protected function schedule(Schedule $schedule): void
    {
<<<<<<< HEAD
        $schedule->command('app:backup-db')->weekly()->sundays()->at('03:00');
        $schedule->command('app:prune-backups')->daily()->at('04:00');
=======
        //
>>>>>>> origin/main
    }
}

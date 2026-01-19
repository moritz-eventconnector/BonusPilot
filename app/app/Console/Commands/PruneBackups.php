<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PruneBackups extends Command
{
    protected $signature = 'app:prune-backups';
    protected $description = 'Remove backups older than 4 weeks.';

    public function handle(): int
    {
        $disk = Storage::disk('local');
        $files = $disk->files('backups');
        $cutoff = now()->subWeeks(4)->timestamp;

        foreach ($files as $file) {
            $modified = $disk->lastModified($file);
            if ($modified < $cutoff) {
                $disk->delete($file);
            }
        }

        $this->info('Old backups pruned.');
        return self::SUCCESS;
    }
}

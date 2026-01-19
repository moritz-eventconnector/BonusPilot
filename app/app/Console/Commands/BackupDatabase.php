<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class BackupDatabase extends Command
{
    protected $signature = 'app:backup-db';
    protected $description = 'Create a database backup.';

    public function handle(): int
    {
        $disk = Storage::disk('local');
        $disk->makeDirectory('backups');

        $timestamp = now()->format('Ymd_His');
        $filename = "backups/bonuspilot_{$timestamp}.sql";
        $path = storage_path('app/'.$filename);

        $config = config('database.connections.pgsql');
        $env = [
            'PGPASSWORD' => $config['password'] ?? '',
        ];

        $result = Process::timeout(600)
            ->env($env)
            ->run([
                'pg_dump',
                '--clean',
                '--if-exists',
                '--no-owner',
                '--no-acl',
                '-h', $config['host'],
                '-p', (string) $config['port'],
                '-U', $config['username'],
                '-d', $config['database'],
                '-f', $path,
            ]);

        if (! $result->successful()) {
            $this->error($result->errorOutput());
            return self::FAILURE;
        }

        $this->info("Backup created: {$filename}");
        return self::SUCCESS;
    }
}

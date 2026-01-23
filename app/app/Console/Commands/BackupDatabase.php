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

        $driver = config('database.default');
        $config = config("database.connections.{$driver}");

        if ($driver === 'pgsql') {
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
        } elseif ($driver === 'mysql') {
            $env = [
                'MYSQL_PWD' => $config['password'] ?? '',
            ];

            $result = Process::timeout(600)
                ->env($env)
                ->run([
                    'mysqldump',
                    '--single-transaction',
                    '--quick',
                    '--routines',
                    '--events',
                    '--triggers',
                    '-h', $config['host'],
                    '-P', (string) $config['port'],
                    '-u', $config['username'],
                    '--result-file', $path,
                    $config['database'],
                ]);
        } else {
            $this->error("Unsupported database driver: {$driver}");
            return self::FAILURE;
        }

        if (! $result->successful()) {
            $this->error($result->errorOutput());
            return self::FAILURE;
        }

        $this->info("Backup created: {$filename}");
        return self::SUCCESS;
    }
}

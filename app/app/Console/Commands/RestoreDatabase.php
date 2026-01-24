<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Storage;

class RestoreDatabase extends Command
{
    protected $signature = 'app:restore-backup {file}';
    protected $description = 'Restore the database from a backup file.';

    public function handle(): int
    {
        $file = basename($this->argument('file'));
        $path = storage_path('app/backups/'.$file);

        if (! file_exists($path)) {
            $this->error('Backup file not found.');
            return self::FAILURE;
        }

        $driver = config('database.default');
        $config = config("database.connections.{$driver}");

        if ($driver === 'pgsql') {
            $env = [
                'PGPASSWORD' => $config['password'] ?? '',
            ];

            $result = Process::timeout(1200)
                ->env($env)
                ->run([
                    'psql',
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

            $result = Process::timeout(1200)
                ->env($env)
                ->run(
                    [
                        'mysql',
                        '-h', $config['host'],
                        '-P', (string) $config['port'],
                        '-u', $config['username'],
                        $config['database'],
                    ],
                    file_get_contents($path)
                );
        } else {
            $this->error("Unsupported database driver: {$driver}");
            return self::FAILURE;
        }

        if (! $result->successful()) {
            $this->error($result->errorOutput());
            return self::FAILURE;
        }

        $this->info('Database restored successfully.');
        return self::SUCCESS;
    }
}

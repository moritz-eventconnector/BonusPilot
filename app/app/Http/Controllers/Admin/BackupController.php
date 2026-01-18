<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BackupController extends Controller
{
    public function index(): View
    {
        $disk = Storage::disk('local');
        $files = collect($disk->files('backups'))
            ->map(function ($file) use ($disk) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => $disk->size($file),
                    'modified' => $disk->lastModified($file),
                ];
            })
            ->sortByDesc('modified')
            ->values();

        return view('admin.backups.index', compact('files'));
    }

    public function store(): RedirectResponse
    {
        Artisan::call('app:backup-db');

        return redirect()->route('admin.backups.index')->with('status', 'Backup created.');
    }

    public function restore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'file' => ['required', 'string'],
        ]);

        Artisan::call('app:restore-backup', ['file' => $data['file']]);

        return redirect()->route('admin.backups.index')->with('status', 'Backup restored.');
    }
}

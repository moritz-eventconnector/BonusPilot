@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Backups</h1>
    <p>Weekly backups run automatically. You can also create or restore a backup below.</p>
    <form method="POST" action="{{ route('admin.backups.store') }}" style="margin-bottom:16px;">
        @csrf
        <button class="btn" type="submit">Create Backup Now</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>File</th>
            <th>Size</th>
            <th>Last Modified</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($files as $file)
            <tr>
                <td>{{ $file['name'] }}</td>
                <td>{{ number_format($file['size'] / 1024, 1) }} KB</td>
                <td>{{ date('Y-m-d H:i', $file['modified']) }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.backups.restore') }}" style="display:inline">
                        @csrf
                        <input type="hidden" name="file" value="{{ $file['name'] }}">
                        <button class="btn btn-secondary" type="submit" onclick="return confirm('Restore this backup? This will overwrite current data.')">Restore</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No backups yet.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

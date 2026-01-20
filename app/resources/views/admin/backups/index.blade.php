@extends('layouts.app')

@section('content')
<div class="card">
    <h1>{{ __('ui.backups.title') }}</h1>
    <p>{{ __('ui.backups.subtitle') }}</p>
    <form method="POST" action="{{ route('admin.backups.store') }}" style="margin-bottom:16px;">
        @csrf
        <button class="btn" type="submit">{{ __('ui.backups.actions.create') }}</button>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>{{ __('ui.backups.table.file') }}</th>
            <th>{{ __('ui.backups.table.size') }}</th>
            <th>{{ __('ui.backups.table.modified') }}</th>
            <th>{{ __('ui.backups.table.actions') }}</th>
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
                        <button class="btn btn-secondary" type="submit" onclick="return confirm('{{ __('ui.backups.confirm_restore') }}')">{{ __('ui.backups.actions.restore') }}</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">{{ __('ui.backups.empty') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

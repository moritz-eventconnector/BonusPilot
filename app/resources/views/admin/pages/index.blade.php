@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h1>{{ __('ui.pages.title') }}</h1>
        <a class="btn" href="{{ route('admin.pages.create') }}">{{ __('ui.pages.actions.new') }}</a>
    </div>
    <p>{{ __('ui.pages.subtitle') }}</p>
    <table class="table">
        <thead>
        <tr>
            <th>{{ __('ui.pages.table.title') }}</th>
            <th>{{ __('ui.pages.table.status') }}</th>
            <th>{{ __('ui.pages.table.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td>{{ __('ui.pages.status.' . $page->status) }}</td>
                <td>
                    <a href="{{ route('admin.pages.edit', $page) }}">{{ __('ui.common.edit') }}</a>
                    <form method="POST" action="{{ route('admin.pages.destroy', $page) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-secondary" type="submit" onclick="return confirm('{{ __('ui.pages.confirm_delete') }}')">{{ __('ui.common.delete') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $pages->links() }}
</div>
@endsection

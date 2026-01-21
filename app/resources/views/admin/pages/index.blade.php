@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h1>{{ __('ui.pages.title') }}</h1>
        <a class="btn" href="{{ route('admin.pages.create') }}">{{ __('ui.pages.actions.new') }}</a>
    </div>
    <p>{{ __('ui.pages.subtitle') }}</p>
    <p class="admin-muted">{{ __('ui.pages.drag_hint') }}</p>
    <table class="table" data-sortable>
        <thead>
        <tr>
            <th></th>
            <th>{{ __('ui.pages.table.title') }}</th>
            <th>{{ __('ui.pages.table.status') }}</th>
            <th>{{ __('ui.pages.table.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            <tr draggable="true" data-id="{{ $page->id }}">
                <td style="width:32px;cursor:grab;">↕</td>
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
<script>
    const pageTable = document.querySelector('[data-sortable]');
    if (pageTable) {
        const tbody = pageTable.querySelector('tbody');
        let draggingRow = null;

        const getRows = () => Array.from(tbody.querySelectorAll('tr'));

        const handleDragStart = (event) => {
            draggingRow = event.currentTarget;
            draggingRow.classList.add('dragging');
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/plain', draggingRow.dataset.id ?? '');
        };

        const handleDragOver = (event) => {
            event.preventDefault();
            const target = event.target.closest('tr');
            if (!target || target === draggingRow) return;
            const rows = getRows();
            const draggingIndex = rows.indexOf(draggingRow);
            const targetIndex = rows.indexOf(target);
            if (draggingIndex < targetIndex) {
                target.after(draggingRow);
            } else {
                target.before(draggingRow);
            }
        };

        const handleDrop = async (event) => {
            event.preventDefault();
            const order = getRows().map((row) => Number(row.dataset.id));
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            await fetch("{{ route('admin.pages.reorder') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token ?? '',
                },
                body: JSON.stringify({ order }),
            });
        };

        const handleDragEnd = () => {
            if (draggingRow) {
                draggingRow.classList.remove('dragging');
            }
            draggingRow = null;
        };

        getRows().forEach((row) => {
            row.addEventListener('dragstart', handleDragStart);
            row.addEventListener('dragover', handleDragOver);
            row.addEventListener('drop', handleDrop);
            row.addEventListener('dragend', handleDragEnd);
        });
    }
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <h1>{{ __('ui.bonuses.title') }}</h1>
        <a class="btn" href="{{ route('admin.bonuses.create') }}">{{ __('ui.bonuses.actions.new') }}</a>
    </div>
    <p>{{ __('ui.bonuses.subtitle') }}</p>
    <table class="table" data-sortable>
        <thead>
        <tr>
            <th></th>
            <th>{{ __('ui.bonuses.table.title') }}</th>
            <th>{{ __('ui.bonuses.table.active') }}</th>
            <th>{{ __('ui.bonuses.table.featured') }}</th>
            <th>{{ __('ui.bonuses.table.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($bonuses as $bonus)
            <tr draggable="true" data-id="{{ $bonus->id }}">
                <td style="width:32px;cursor:grab;">↕</td>
                <td>{{ $bonus->title }}</td>
                <td>{{ $bonus->is_active ? __('ui.common.yes') : __('ui.common.no') }}</td>
                <td>{{ $bonus->is_featured ? __('ui.common.yes') : __('ui.common.no') }}</td>
                <td>
                    <a href="{{ route('admin.bonuses.edit', $bonus) }}">{{ __('ui.common.edit') }}</a>
                    <form method="POST" action="{{ route('admin.bonuses.destroy', $bonus) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('{{ __('ui.bonuses.confirm_delete') }}')">{{ __('ui.common.delete') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script>
    const table = document.querySelector('[data-sortable]');
    if (table) {
        const tbody = table.querySelector('tbody');
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
            await fetch("{{ route('admin.bonuses.reorder') }}", {
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

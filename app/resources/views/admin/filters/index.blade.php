@extends('layouts.app')

@section('content')
<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-toolbar">
        <div>
            <h2 style="margin:0;">{{ __('ui.filters.title') }}</h2>
            <p class="admin-muted" style="margin:6px 0 0;">{{ __('ui.filters.subtitle') }}</p>
        </div>
    </div>
</div>

<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
    <div class="admin-card">
        <div class="form-section">
            <h3>{{ __('ui.filters.new_option') }}</h3>
            <form method="POST" action="{{ route('admin.filters.options.store') }}">
                @csrf
                <input type="hidden" name="filter_group_id" value="{{ $defaultGroup->id }}">
                <div class="form-group">
                    <label>{{ __('ui.filters.fields.name') }}</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label><input type="checkbox" name="is_active" value="1" checked> {{ __('ui.filters.fields.active') }}</label>
                </div>
                <button class="btn" type="submit">{{ __('ui.filters.actions.create') }}</button>
            </form>
        </div>
    </div>
</div>

<div class="admin-card" style="margin-top:20px;">
    <h2 style="margin-top:0;">{{ __('ui.filters.existing') }}</h2>
    @if($options->isEmpty())
        <p class="admin-muted">{{ __('ui.filters.empty') }}</p>
    @else
        <p class="admin-muted">{{ __('ui.filters.reorder_hint') }}</p>
        <div class="grid filter-options-list" data-reorder-url="{{ route('admin.filters.reorder') }}" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));gap:12px;">
            @foreach($options as $option)
                <div class="card filter-option-card" style="margin-bottom:0;" data-option-id="{{ $option->id }}">
                    <div class="admin-inline" style="justify-content:space-between;margin-bottom:10px;">
                        <strong>{{ $option->name }}</strong>
                        <div class="admin-inline" style="gap:6px;">
                            <button class="btn btn-secondary btn-icon" type="button" data-move="up" aria-label="{{ __('ui.filters.actions.move_up') }}">↑</button>
                            <button class="btn btn-secondary btn-icon" type="button" data-move="down" aria-label="{{ __('ui.filters.actions.move_down') }}">↓</button>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('admin.filters.options.update', $option) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label>{{ __('ui.filters.fields.name') }}</label>
                            <input type="text" name="name" value="{{ old('name', $option->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $option->is_active) ? 'checked' : '' }}> {{ __('ui.filters.fields.active') }}</label>
                        </div>
                        <div class="admin-inline">
                            <button class="btn" type="submit">{{ __('ui.filters.actions.save') }}</button>
                            <button class="btn btn-secondary" type="submit" form="delete-option-{{ $option->id }}">{{ __('ui.filters.actions.delete') }}</button>
                        </div>
                    </form>
                    <form id="delete-option-{{ $option->id }}" method="POST" action="{{ route('admin.filters.options.destroy', $option) }}">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const list = document.querySelector('.filter-options-list');
        if (!list) {
            return;
        }

        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const sendOrder = () => {
            const order = Array.from(list.querySelectorAll('.filter-option-card')).map((card) =>
                Number(card.dataset.optionId)
            );
            fetch(list.dataset.reorderUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({ order }),
            });
        };

        list.addEventListener('click', (event) => {
            const button = event.target.closest('[data-move]');
            if (!button) {
                return;
            }
            const card = button.closest('.filter-option-card');
            if (!card) {
                return;
            }
            if (button.dataset.move === 'up' && card.previousElementSibling) {
                list.insertBefore(card, card.previousElementSibling);
                sendOrder();
            }
            if (button.dataset.move === 'down' && card.nextElementSibling) {
                list.insertBefore(card.nextElementSibling, card);
                sendOrder();
            }
        });
    });
</script>
@endsection

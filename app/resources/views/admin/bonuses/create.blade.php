@extends('layouts.app')

@section('content')
<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-toolbar">
        <div>
            <h1 style="margin:0;">{{ __('ui.bonuses.create_title') }}</h1>
            <p class="admin-muted" style="margin:6px 0 0;">{{ __('ui.bonuses.create_subtitle') }}</p>
        </div>
        <a class="btn btn-secondary" href="{{ route('admin.bonuses.index') }}">{{ __('ui.common.back_to_overview') }}</a>
    </div>
</div>

<div class="card">
    <form method="POST" action="{{ route('admin.bonuses.store') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.bonuses.partials.form', ['bonus' => null, 'selectedOptions' => [], 'options' => $options])
        <div class="admin-inline" style="margin-top:16px;">
            <button class="btn" type="submit">{{ __('ui.bonuses.actions.save') }}</button>
            <a class="btn btn-secondary" href="{{ route('admin.bonuses.index') }}">{{ __('ui.common.cancel') }}</a>
        </div>
    </form>
</div>
@endsection

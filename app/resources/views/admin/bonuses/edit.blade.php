@extends('layouts.app')

@section('content')
<div class="admin-card" style="margin-bottom:20px;">
    <div class="admin-toolbar">
        <div>
            <h1 style="margin:0;">{{ __('ui.bonuses.edit_title') }}</h1>
            <p class="admin-muted" style="margin:6px 0 0;">{{ __('ui.bonuses.edit_subtitle') }}</p>
        </div>
        <a class="btn btn-secondary" href="{{ route('admin.bonuses.index') }}">{{ __('ui.common.back_to_overview') }}</a>
    </div>
</div>

<div class="card">
    @if($errors->any())
        <div class="alert alert-error">
            <strong>{{ __('ui.common.validation_error') }}</strong>
            <ul style="margin:8px 0 0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('admin.bonuses.update', $bonus) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.bonuses.partials.form', ['bonus' => $bonus, 'selectedOptions' => $selectedOptions, 'options' => $options])
        <div class="admin-inline" style="margin-top:16px;">
            <button class="btn" type="submit">{{ __('ui.bonuses.actions.save_changes') }}</button>
            <a class="btn btn-secondary" href="{{ route('admin.bonuses.index') }}">{{ __('ui.common.cancel') }}</a>
        </div>
    </form>
</div>
@endsection

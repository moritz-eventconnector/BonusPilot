@extends('layouts.app')

@section('content')
<div class="card">
    <h1>{{ __('ui.settings.title') }}</h1>
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>{{ __('ui.settings.logo') }}</label>
            <input type="file" name="logo" accept="image/png,image/jpeg,image/svg+xml">
        </div>
        <div class="form-group">
            <label>{{ __('ui.settings.favicon') }}</label>
            <input type="file" name="favicon" accept="image/png,image/x-icon,image/svg+xml">
            @if($settings->get('favicon_path'))
                <label><input type="checkbox" name="remove_favicon" value="1"> {{ __('ui.settings.remove_favicon') }}</label>
            @endif
        </div>
        <div class="grid grid-3">
            <div class="form-group">
                <label>{{ __('ui.settings.site_name') }}</label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings->get('site_name')) }}" placeholder="BonusPilot">
            </div>
            <div class="form-group">
                <label>{{ __('ui.settings.site_title') }}</label>
                <input type="text" name="site_title" value="{{ old('site_title', $settings->get('site_title')) }}" placeholder="BonusPilot">
            </div>
            <div class="form-group">
                <label>{{ __('ui.settings.primary_color') }}</label>
                <input type="text" name="primary_color" value="{{ old('primary_color', $settings->get('primary_color')) }}" placeholder="#2563eb">
            </div>
            <div class="form-group">
                <label>{{ __('ui.settings.secondary_color') }}</label>
                <input type="text" name="secondary_color" value="{{ old('secondary_color', $settings->get('secondary_color')) }}" placeholder="#1f2937">
            </div>
            <div class="form-group">
                <label>{{ __('ui.settings.background_color') }}</label>
                <input type="text" name="background_color" value="{{ old('background_color', $settings->get('background_color')) }}" placeholder="#0b345c">
            </div>
            <div class="form-group">
                <label>{{ __('ui.settings.header_background') }}</label>
                <input type="text" name="header_background" value="{{ old('header_background', $settings->get('header_background')) }}" placeholder="linear-gradient(180deg, #0f172a, #020617)">
            </div>
            <div class="form-group">
                <label>{{ __('ui.settings.background_image') }}</label>
                <input type="file" name="background_image" accept="image/*">
                @if($settings->get('background_image_path'))
                    <label><input type="checkbox" name="remove_background_image" value="1"> {{ __('ui.settings.remove_background_image') }}</label>
                @endif
            </div>
        </div>
        <h3>{{ __('ui.settings.hero') }}</h3>
        <div class="grid grid-3">
            <div class="form-group">
                <label><input type="checkbox" name="home_hero_enabled" value="1" {{ old('home_hero_enabled', $settings->get('home_hero_enabled', '1')) !== '0' ? 'checked' : '' }}> {{ __('ui.settings.hero_enabled') }}</label>
            </div>
            <div class="form-group">
                <label>{{ __('ui.settings.hero_title') }}</label>
                <input type="text" name="home_hero_title" value="{{ old('home_hero_title', $settings->get('home_hero_title')) }}" placeholder="{{ __('ui.home.hero_title_default') }}">
            </div>
            <div class="form-group">
                <label>{{ __('ui.settings.hero_subtitle') }}</label>
                <input type="text" name="home_hero_subtitle" value="{{ old('home_hero_subtitle', $settings->get('home_hero_subtitle')) }}" placeholder="{{ __('ui.home.hero_subtitle_default') }}">
            </div>
        </div>
        <h3>{{ __('ui.settings.social') }}</h3>
        <div class="grid grid-3">
            <div class="form-group">
                <label>Instagram</label>
                <input type="url" name="instagram" value="{{ old('instagram', $settings->get('instagram')) }}">
            </div>
            <div class="form-group">
                <label>Telegram</label>
                <input type="url" name="telegram" value="{{ old('telegram', $settings->get('telegram')) }}">
            </div>
            <div class="form-group">
                <label>Discord</label>
                <input type="url" name="discord" value="{{ old('discord', $settings->get('discord')) }}">
            </div>
            <div class="form-group">
                <label>TikTok</label>
                <input type="url" name="tiktok" value="{{ old('tiktok', $settings->get('tiktok')) }}">
            </div>
            <div class="form-group">
                <label>YouTube</label>
                <input type="url" name="youtube" value="{{ old('youtube', $settings->get('youtube')) }}">
            </div>
            <div class="form-group">
                <label>Twitch</label>
                <input type="url" name="twitch" value="{{ old('twitch', $settings->get('twitch')) }}">
            </div>
            <div class="form-group">
                <label>Kick</label>
                <input type="url" name="kick" value="{{ old('kick', $settings->get('kick')) }}">
            </div>
        </div>
        <button class="btn" type="submit">{{ __('ui.settings.save') }}</button>
    </form>
</div>
@endsection

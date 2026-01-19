@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Settings</h1>
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Logo (PNG/JPG/SVG)</label>
            <input type="file" name="logo" accept="image/png,image/jpeg,image/svg+xml">
        </div>
        <div class="form-group">
            <label>Favicon (PNG/ICO/SVG)</label>
            <input type="file" name="favicon" accept="image/png,image/x-icon,image/svg+xml">
            @if($settings->get('favicon_path'))
                <label><input type="checkbox" name="remove_favicon" value="1"> Remove favicon</label>
            @endif
        </div>
        <div class="grid grid-3">
            <div class="form-group">
                <label>Site Name</label>
                <input type="text" name="site_name" value="{{ old('site_name', $settings->get('site_name')) }}" placeholder="BonusPilot">
            </div>
            <div class="form-group">
                <label>Site Title (Browser Tab)</label>
                <input type="text" name="site_title" value="{{ old('site_title', $settings->get('site_title')) }}" placeholder="BonusPilot">
            </div>
            <div class="form-group">
                <label>Primary Color</label>
                <input type="text" name="primary_color" value="{{ old('primary_color', $settings->get('primary_color')) }}" placeholder="#2563eb">
            </div>
            <div class="form-group">
                <label>Secondary Color</label>
                <input type="text" name="secondary_color" value="{{ old('secondary_color', $settings->get('secondary_color')) }}" placeholder="#1f2937">
            </div>
            <div class="form-group">
                <label>Background Color</label>
                <input type="text" name="background_color" value="{{ old('background_color', $settings->get('background_color')) }}" placeholder="#f9fafb">
            </div>
            <div class="form-group">
                <label>Background Image (optional)</label>
                <input type="file" name="background_image" accept="image/*">
                @if($settings->get('background_image_path'))
                    <label><input type="checkbox" name="remove_background_image" value="1"> Remove background image</label>
                @endif
            </div>
        </div>
        <h3>Homepage Hero</h3>
        <div class="grid grid-3">
            <div class="form-group">
                <label><input type="checkbox" name="home_hero_enabled" value="1" {{ old('home_hero_enabled', $settings->get('home_hero_enabled', '1')) !== '0' ? 'checked' : '' }}> Show hero text</label>
            </div>
            <div class="form-group">
                <label>Hero Title</label>
                <input type="text" name="home_hero_title" value="{{ old('home_hero_title', $settings->get('home_hero_title')) }}" placeholder="Bonus Highlights">
            </div>
            <div class="form-group">
                <label>Hero Subtitle</label>
                <input type="text" name="home_hero_subtitle" value="{{ old('home_hero_subtitle', $settings->get('home_hero_subtitle')) }}" placeholder="Filtere deine Boni und klicke auf ⓘ für mehr Details.">
            </div>
        </div>
        <h3>Social Links</h3>
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
        </div>
        <button class="btn" type="submit">Save Settings</button>
    </form>
</div>
@endsection

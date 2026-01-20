<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function edit(): View
    {
        $settings = Setting::all()->pluck('value', 'key');

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'logo' => ['nullable', 'file', 'mimes:png,jpg,jpeg,svg', 'max:2048'],
            'favicon' => ['nullable', 'file', 'mimes:png,ico,svg', 'max:1024'],
            'primary_color' => ['nullable', 'string', 'max:20'],
            'secondary_color' => ['nullable', 'string', 'max:20'],
            'background_color' => ['nullable', 'string', 'max:20'],
            'header_background' => ['nullable', 'string', 'max:120'],
            'background_image' => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp', 'max:4096'],
            'site_name' => ['nullable', 'string', 'max:120'],
            'site_title' => ['nullable', 'string', 'max:255'],
            'home_hero_title' => ['nullable', 'string', 'max:120'],
            'home_hero_subtitle' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'url'],
            'telegram' => ['nullable', 'url'],
            'discord' => ['nullable', 'url'],
            'tiktok' => ['nullable', 'url'],
            'youtube' => ['nullable', 'url'],
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->storeAs('brand', 'logo.png', 'public');
            Setting::updateOrCreate(['key' => 'logo_path'], ['value' => $path]);
        }

        if ($request->boolean('remove_background_image')) {
            $existingBackground = Setting::where('key', 'background_image_path')->value('value');
            if ($existingBackground && Storage::disk('public')->exists($existingBackground)) {
                Storage::disk('public')->delete($existingBackground);
            }
            Setting::updateOrCreate(['key' => 'background_image_path'], ['value' => null]);
        }

        if ($request->hasFile('background_image')) {
            $extension = $request->file('background_image')->getClientOriginalExtension();
            $path = $request->file('background_image')->storeAs('brand', "background.{$extension}", 'public');
            Setting::updateOrCreate(['key' => 'background_image_path'], ['value' => $path]);
        }

        if ($request->boolean('remove_favicon')) {
            $existingFavicon = Setting::where('key', 'favicon_path')->value('value');
            if ($existingFavicon && Storage::disk('public')->exists($existingFavicon)) {
                Storage::disk('public')->delete($existingFavicon);
            }
            Setting::updateOrCreate(['key' => 'favicon_path'], ['value' => null]);
        }

        if ($request->hasFile('favicon')) {
            $extension = $request->file('favicon')->getClientOriginalExtension();
            $path = $request->file('favicon')->storeAs('brand', "favicon.{$extension}", 'public');
            Setting::updateOrCreate(['key' => 'favicon_path'], ['value' => $path]);
        }

        $keys = [
            'site_name',
            'site_title',
            'primary_color',
            'secondary_color',
            'background_color',
            'header_background',
            'home_hero_title',
            'home_hero_subtitle',
            'instagram',
            'telegram',
            'discord',
            'tiktok',
            'youtube',
        ];

        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $validated[$key] ?? null]
            );
        }

        Setting::updateOrCreate(
            ['key' => 'home_hero_enabled'],
            ['value' => $request->boolean('home_hero_enabled') ? '1' : '0']
        );

        return redirect()->route('admin.settings.edit')->with('status', __('ui.settings.updated'));
    }
}

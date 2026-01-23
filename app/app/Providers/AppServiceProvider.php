<?php

namespace App\Providers;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            $settings = Setting::all()->pluck('value', 'key');
            $navPages = Page::where('status', 'published')
                ->orderBy('nav_order')
                ->orderBy('title')
                ->get(['id', 'title', 'slug']);
            $view->with('settings', $settings);
            $view->with('navPages', $navPages);
        });
    }
}

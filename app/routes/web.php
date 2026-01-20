<?php

use App\Http\Controllers\Admin\BonusController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::middleware('track')->group(function () {
    Route::get('/', [PublicController::class, 'index'])->name('home');
    Route::get('/bonus/{slug}', [PublicController::class, 'showBonus'])->name('bonus.show');
    Route::get('/p/{slug}', [PublicController::class, 'showPage'])->name('page.show');
});
Route::get('/bonus-icon/{bonus}', [PublicController::class, 'bonusIcon'])->name('bonus.icon');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.bonuses.index');
    })->name('dashboard');

    Route::resource('bonuses', BonusController::class)->except(['show']);
    Route::post('bonuses/reorder', [BonusController::class, 'reorder'])->name('bonuses.reorder');

    Route::get('filters', [FilterController::class, 'index'])->name('filters.index');
    Route::post('filters/groups', [FilterController::class, 'storeGroup'])->name('filters.groups.store');
    Route::patch('filters/groups/{group}', [FilterController::class, 'updateGroup'])->name('filters.groups.update');
    Route::delete('filters/groups/{group}', [FilterController::class, 'destroyGroup'])->name('filters.groups.destroy');
    Route::post('filters/options', [FilterController::class, 'storeOption'])->name('filters.options.store');
    Route::patch('filters/options/{option}', [FilterController::class, 'updateOption'])->name('filters.options.update');
    Route::delete('filters/options/{option}', [FilterController::class, 'destroyOption'])->name('filters.options.destroy');

    Route::resource('pages', PageController::class)->except(['show']);

    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    Route::get('settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('backups', [BackupController::class, 'store'])->name('backups.store');
    Route::post('backups/restore', [BackupController::class, 'restore'])->name('backups.restore');
});

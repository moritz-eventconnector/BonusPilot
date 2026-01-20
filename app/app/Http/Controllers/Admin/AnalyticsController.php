<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $since = now()->subDays(30);

        $totalVisits = Visit::query()
            ->where('visited_at', '>=', $since)
            ->count();

        $dailyVisits = Visit::query()
            ->where('visited_at', '>=', $since)
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $sources = Visit::query()
            ->where('visited_at', '>=', $since)
            ->selectRaw("COALESCE(NULLIF(utm_source, ''), NULLIF(referrer_host, ''), 'Direkt') as source, COUNT(*) as total")
            ->groupBy('source')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $topPages = Visit::query()
            ->where('visited_at', '>=', $since)
            ->selectRaw('path, COUNT(*) as total')
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        return view('admin.analytics.index', [
            'since' => $since,
            'totalVisits' => $totalVisits,
            'dailyVisits' => $dailyVisits,
            'sources' => $sources,
            'topPages' => $topPages,
        ]);
    }
}

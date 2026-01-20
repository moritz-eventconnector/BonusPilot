<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->filled('from')
            ? Carbon::parse($request->input('from'))->startOfDay()
            : now()->subDays(30)->startOfDay();
        $end = $request->filled('to')
            ? Carbon::parse($request->input('to'))->endOfDay()
            : now()->endOfDay();

        if ($start->greaterThan($end)) {
            [$start, $end] = [$end, $start];
        }

        $totalVisits = Visit::query()
            ->whereBetween('visited_at', [$start, $end])
            ->count();

        $dailyVisits = Visit::query()
            ->whereBetween('visited_at', [$start, $end])
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $sources = Visit::query()
            ->whereBetween('visited_at', [$start, $end])
            ->selectRaw("COALESCE(NULLIF(utm_source, ''), NULLIF(referrer_host, ''), 'Direkt') as source, COUNT(*) as total")
            ->groupBy('source')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $topPages = Visit::query()
            ->whereBetween('visited_at', [$start, $end])
            ->selectRaw('path, COUNT(*) as total')
            ->groupBy('path')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        return view('admin.analytics.index', [
            'start' => $start,
            'end' => $end,
            'totalVisits' => $totalVisits,
            'dailyVisits' => $dailyVisits,
            'sources' => $sources,
            'topPages' => $topPages,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\FilterOption;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(Request $request): View
    {
        $filterSlug = $request->input('filter');
        $legacyFilters = $request->input('filters', []);
        if (!$filterSlug && is_array($legacyFilters) && count($legacyFilters)) {
            $filterSlug = $legacyFilters[0];
        }

        $options = FilterOption::where('is_active', true)
            ->orderBy('name')
            ->get();

        $bonuses = Bonus::with('filterOptions')
            ->where('is_active', true)
            ->when($filterSlug, function ($query) use ($filterSlug) {
                $query->whereHas('filterOptions', function ($subQuery) use ($filterSlug) {
                    $subQuery->where('slug', $filterSlug);
                });
            })
            ->orderBy('sort_order')
            ->get();

        return view('public.index', compact('options', 'bonuses', 'filterSlug'));
    }

    public function showPage(string $slug): View
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.page', compact('page'));
    }

    public function bonusIcon(Bonus $bonus): Response
    {
        if (!$bonus->bonus_icon_path || !Storage::disk('public')->exists($bonus->bonus_icon_path)) {
            abort(404);
        }

        return Storage::disk('public')->response($bonus->bonus_icon_path);
    }
}

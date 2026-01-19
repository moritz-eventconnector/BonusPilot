<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\FilterGroup;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(Request $request): View
    {
        $filterSlugs = $request->input('filters', []);
        $filterSlugs = is_array($filterSlugs) ? $filterSlugs : [$filterSlugs];

        $groups = FilterGroup::with(['options' => function ($query) {
            $query->where('is_active', true)->orderBy('sort_order');
        }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $bonuses = Bonus::with('filterOptions')
            ->where('is_active', true)
            ->when(count($filterSlugs) > 0, function ($query) use ($filterSlugs) {
                $query->whereHas('filterOptions', function ($subQuery) use ($filterSlugs) {
                    $subQuery->whereIn('slug', $filterSlugs);
                });
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return view('public.index', compact('groups', 'bonuses', 'filterSlugs'));
    }

    public function showBonus(string $slug): View
    {
        $bonus = Bonus::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('public.bonus', compact('bonus'));
    }

    public function showPage(string $slug): View
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('public.page', compact('page'));
    }
}

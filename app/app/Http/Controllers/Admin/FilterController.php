<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FilterGroup;
use App\Models\FilterOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FilterController extends Controller
{
    public function index(): View
    {
        $groups = FilterGroup::with('options')->orderBy('sort_order')->get();

        return view('admin.filters.index', compact('groups'));
    }

    public function storeGroup(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $request->validate([
            'name' => ['required', Rule::unique('filter_groups', 'name')],
        ]);

        FilterGroup::create($data);

        return redirect()->route('admin.filters.index')->with('status', 'Filter group created.');
    }

    public function storeOption(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'filter_group_id' => ['required', 'exists:filter_groups,id'],
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $request->validate([
            'name' => ['required', Rule::unique('filter_options', 'name')],
        ]);

        FilterOption::create($data);

        return redirect()->route('admin.filters.index')->with('status', 'Filter option created.');
    }
}

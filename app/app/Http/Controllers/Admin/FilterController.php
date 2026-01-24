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
        $defaultGroup = $this->defaultGroup();
        $options = FilterOption::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.filters.index', compact('options', 'defaultGroup'));
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

        return redirect()->route('admin.filters.index')->with('status', __('ui.filters.group_created'));
    }

    public function updateGroup(Request $request, FilterGroup $group): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $request->validate([
            'name' => ['required', Rule::unique('filter_groups', 'name')->ignore($group->id)],
        ]);

        $group->update($data);

        return redirect()->route('admin.filters.index')->with('status', __('ui.filters.group_updated'));
    }

    public function destroyGroup(FilterGroup $group): RedirectResponse
    {
        $group->delete();

        return redirect()->route('admin.filters.index')->with('status', __('ui.filters.group_deleted'));
    }

    public function storeOption(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'filter_group_id' => ['nullable', 'exists:filter_groups,id'],
        ]);

        $data['filter_group_id'] = $data['filter_group_id'] ?? $this->defaultGroup()->id;
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $request->validate([
            'name' => ['required', Rule::unique('filter_options', 'name')],
        ]);

        FilterOption::create($data);

        return redirect()->route('admin.filters.index')->with('status', __('ui.filters.option_created'));
    }

    public function updateOption(Request $request, FilterOption $option): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'filter_group_id' => ['nullable', 'exists:filter_groups,id'],
        ]);

        $data['filter_group_id'] = $data['filter_group_id'] ?? $option->filter_group_id ?? $this->defaultGroup()->id;
        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');

        $request->validate([
            'name' => ['required', Rule::unique('filter_options', 'name')->ignore($option->id)],
        ]);

        $option->update($data);

        return redirect()->route('admin.filters.index')->with('status', __('ui.filters.option_updated'));
    }

    public function destroyOption(FilterOption $option): RedirectResponse
    {
        $option->delete();

        return redirect()->route('admin.filters.index')->with('status', __('ui.filters.option_deleted'));
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:filter_options,id'],
        ]);

        foreach ($data['order'] as $index => $optionId) {
            FilterOption::whereKey($optionId)->update(['sort_order' => $index]);
        }

        return response()->noContent();
    }

    private function defaultGroup(): FilterGroup
    {
        return FilterGroup::firstOrCreate(
            ['slug' => 'default'],
            ['name' => 'Default', 'is_active' => true, 'sort_order' => 0]
        );
    }
}

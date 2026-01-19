<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\FilterGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BonusController extends Controller
{
    public function index(): View
    {
        $bonuses = Bonus::with('filterOptions')
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.bonuses.index', compact('bonuses'));
    }

    public function create(): View
    {
        $groups = FilterGroup::with('options')->get();

        return view('admin.bonuses.create', compact('groups'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        $request->validate([
            'title' => ['required', Rule::unique('bonuses', 'title')],
        ]);

        $bonus = Bonus::create($data);
        $bonus->filterOptions()->sync($request->input('filter_options', []));

        return redirect()->route('admin.bonuses.index')->with('status', 'Bonus created.');
    }

    public function edit(Bonus $bonus): View
    {
        $groups = FilterGroup::with('options')->get();
        $selectedOptions = $bonus->filterOptions()->pluck('filter_option_id')->all();

        return view('admin.bonuses.edit', compact('bonus', 'groups', 'selectedOptions'));
    }

    public function update(Request $request, Bonus $bonus): RedirectResponse
    {
        $data = $this->validateData($request, $bonus->id);
        $data['slug'] = Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        $request->validate([
            'title' => ['required', Rule::unique('bonuses', 'title')->ignore($bonus->id)],
        ]);

        $bonus->update($data);
        $bonus->filterOptions()->sync($request->input('filter_options', []));

        return redirect()->route('admin.bonuses.index')->with('status', 'Bonus updated.');
    }

    public function destroy(Bonus $bonus): RedirectResponse
    {
        $bonus->delete();

        return redirect()->route('admin.bonuses.index')->with('status', 'Bonus deleted.');
    }

    private function validateData(Request $request, ?int $bonusId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'casino_name' => ['nullable', 'string', 'max:255'],
            'short_text' => ['nullable', 'string', 'max:255'],
            'content' => ['nullable', 'string'],
            'bonus_code' => ['nullable', 'string', 'max:255'],
            'bonus_percent' => ['nullable', 'integer', 'min:0'],
            'max_bonus' => ['nullable', 'string', 'max:255'],
            'max_bet' => ['nullable', 'string', 'max:255'],
            'wager' => ['nullable', 'string', 'max:255'],
            'free_spins' => ['nullable', 'string', 'max:255'],
            'cta_label' => ['nullable', 'string', 'max:255'],
            'play_url' => ['nullable', 'url'],
            'terms_url' => ['nullable', 'url'],
            'back_text' => ['nullable', 'string'],
            'payment_methods' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }
}

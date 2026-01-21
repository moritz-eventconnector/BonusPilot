<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bonus;
use App\Models\FilterOption;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            ->get();

        return view('admin.bonuses.index', compact('bonuses'));
    }

    public function create(): View
    {
        $options = FilterOption::orderBy('name')->get();

        return view('admin.bonuses.create', compact('options'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['payment_methods'] = $this->serializePaymentMethods($data['payment_methods'] ?? null);
        $data['slug'] = Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        $request->validate([
            'title' => ['required', Rule::unique('bonuses', 'title')],
        ]);

        $bonus = Bonus::create($data);
        $this->handleIconUpload($request, $bonus);
        $bonus->filterOptions()->sync($request->input('filter_options', []));

        return redirect()->route('admin.bonuses.index')->with('status', __('ui.bonuses.created'));
    }

    public function edit(Bonus $bonus): View
    {
        $options = FilterOption::orderBy('name')->get();
        $selectedOptions = $bonus->filterOptions()->pluck('filter_option_id')->all();

        return view('admin.bonuses.edit', compact('bonus', 'options', 'selectedOptions'));
    }

    public function update(Request $request, Bonus $bonus): RedirectResponse
    {
        $data = $this->validateData($request, $bonus->id);
        $data['payment_methods'] = $this->serializePaymentMethods($data['payment_methods'] ?? null);
        $data['slug'] = Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');

        $request->validate([
            'title' => ['required', Rule::unique('bonuses', 'title')->ignore($bonus->id)],
        ]);

        $bonus->update($data);
        $this->handleIconUpload($request, $bonus);
        $bonus->filterOptions()->sync($request->input('filter_options', []));

        return redirect()->route('admin.bonuses.index')->with('status', __('ui.bonuses.updated'));
    }

    public function destroy(Bonus $bonus): RedirectResponse
    {
        $bonus->delete();

        return redirect()->route('admin.bonuses.index')->with('status', __('ui.bonuses.deleted'));
    }

    public function reorder(Request $request)
    {
        $data = $request->validate([
            'order' => ['required', 'array'],
            'order.*' => ['integer', 'exists:bonuses,id'],
        ]);

        foreach ($data['order'] as $index => $bonusId) {
            Bonus::whereKey($bonusId)->update(['sort_order' => $index]);
        }

        return response()->noContent();
    }

    private function validateData(Request $request, ?int $bonusId = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'casino_name' => ['nullable', 'string', 'max:255'],
            'short_text' => ['nullable', 'string', 'max:255'],
            'bonus_code' => ['nullable', 'string', 'max:255'],
            'bonus_code_label' => ['nullable', 'string', 'max:255'],
            'bonus_percent' => ['nullable', 'integer', 'min:0'],
            'bonus_percent_label' => ['nullable', 'string', 'max:255'],
            'max_bonus' => ['nullable', 'string', 'max:255'],
            'max_bonus_label' => ['nullable', 'string', 'max:255'],
            'max_bet' => ['nullable', 'string', 'max:255'],
            'max_bet_label' => ['nullable', 'string', 'max:255'],
            'wager' => ['nullable', 'string', 'max:255'],
            'wager_label' => ['nullable', 'string', 'max:255'],
            'free_spins' => ['nullable', 'string', 'max:255'],
            'cta_label' => ['nullable', 'string', 'max:255'],
            'play_url' => ['nullable', 'url'],
            'terms_url' => ['nullable', 'url'],
            'back_text' => ['nullable', 'string'],
            'payment_methods' => ['nullable', 'array'],
            'payment_methods.*' => ['string', Rule::in(Bonus::PAYMENT_METHODS)],
            'go_back_label' => ['nullable', 'string', 'max:255'],
            'bonus_icon' => ['nullable', 'file', 'mimes:jpg,jpeg,png,svg', 'max:2048'],
        ]);
    }

    private function serializePaymentMethods(?array $methods): ?string
    {
        if (!$methods) {
            return null;
        }

        return json_encode(array_values($methods), JSON_UNESCAPED_UNICODE);
    }

    private function handleIconUpload(Request $request, Bonus $bonus): void
    {
        if (!$request->hasFile('bonus_icon')) {
            return;
        }

        if ($bonus->bonus_icon_path) {
            Storage::disk('public')->delete($bonus->bonus_icon_path);
        }

        $path = $request->file('bonus_icon')->store('bonuses/icons', 'public');
        $bonus->update(['bonus_icon_path' => $path]);
    }
}

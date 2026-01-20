<div class="form-section">
    <h3>{{ __('ui.bonuses.form.basics') }}</h3>
    <div class="grid grid-2">
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.title') }}</label>
            <input type="text" name="title" value="{{ old('title', $bonus->title ?? '') }}" required>
            <span class="form-help">{{ __('ui.bonuses.form.title_help') }}</span>
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.casino_name') }}</label>
            <input type="text" name="casino_name" value="{{ old('casino_name', $bonus->casino_name ?? '') }}">
            <span class="form-help">{{ __('ui.bonuses.form.casino_name_help') }}</span>
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.short_text') }}</label>
            <input type="text" name="short_text" value="{{ old('short_text', $bonus->short_text ?? '') }}">
            <span class="form-help">{{ __('ui.bonuses.form.short_text_help') }}</span>
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.bonus_icon') }}</label>
            <input type="file" name="bonus_icon" accept=".png,.jpg,.jpeg,.svg">
            @if(!empty($bonus?->bonus_icon_path))
                <div style="margin-top:8px;">
                    <img src="{{ route('bonus.icon', $bonus) }}" alt="{{ __('ui.bonuses.form.bonus_icon_alt') }}" style="max-height:48px;">
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>{{ __('ui.bonuses.form.description') }}</label>
        <textarea name="content" rows="4">{{ old('content', $bonus->content ?? '') }}</textarea>
        <span class="form-help">{{ __('ui.bonuses.form.description_help') }}</span>
    </div>
</div>

<div class="form-section">
    <h3>{{ __('ui.bonuses.form.values') }}</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.promo_code') }}</label>
            <input type="text" name="bonus_code" value="{{ old('bonus_code', $bonus->bonus_code ?? '') }}">
            <span class="form-help">{{ __('ui.bonuses.form.promo_code_help') }}</span>
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.promo_code_label') }}</label>
            <input type="text" name="bonus_code_label" value="{{ old('bonus_code_label', $bonus->bonus_code_label ?? '') }}" placeholder="{{ __('ui.bonuses.form.placeholders.code') }}">
            <span class="form-help">{{ __('ui.bonuses.form.promo_code_label_help') }}</span>
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.bonus_percent') }}</label>
            <input type="number" name="bonus_percent" value="{{ old('bonus_percent', $bonus->bonus_percent ?? '') }}">
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.max_bonus') }}</label>
            <input type="text" name="max_bonus" value="{{ old('max_bonus', $bonus->max_bonus ?? '') }}">
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.max_bet') }}</label>
            <input type="text" name="max_bet" value="{{ old('max_bet', $bonus->max_bet ?? '') }}">
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.wager') }}</label>
            <input type="text" name="wager" value="{{ old('wager', $bonus->wager ?? '') }}">
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.free_spins') }}</label>
            <input type="text" name="free_spins" value="{{ old('free_spins', $bonus->free_spins ?? '') }}">
        </div>
    </div>
</div>

<div class="form-section">
    <h3>{{ __('ui.bonuses.form.labels') }}</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.label_bonus') }}</label>
            <input type="text" name="bonus_percent_label" value="{{ old('bonus_percent_label', $bonus->bonus_percent_label ?? '') }}" placeholder="{{ __('ui.bonuses.form.placeholders.bonus_percent') }}">
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.label_max_bonus') }}</label>
            <input type="text" name="max_bonus_label" value="{{ old('max_bonus_label', $bonus->max_bonus_label ?? '') }}" placeholder="{{ __('ui.bonuses.form.placeholders.max_bonus') }}">
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.label_max_bet') }}</label>
            <input type="text" name="max_bet_label" value="{{ old('max_bet_label', $bonus->max_bet_label ?? '') }}" placeholder="{{ __('ui.bonuses.form.placeholders.max_bet') }}">
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.label_wager') }}</label>
            <input type="text" name="wager_label" value="{{ old('wager_label', $bonus->wager_label ?? '') }}" placeholder="{{ __('ui.bonuses.form.placeholders.wager') }}">
        </div>
    </div>
</div>

<div class="form-section">
    <h3>{{ __('ui.bonuses.form.links') }}</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.cta_label') }}</label>
            <input type="text" name="cta_label" value="{{ old('cta_label', $bonus->cta_label ?? '') }}" placeholder="{{ __('ui.bonuses.form.placeholders.cta') }}">
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.play_url') }}</label>
            <input type="url" name="play_url" value="{{ old('play_url', $bonus->play_url ?? '') }}">
            <span class="form-help">{{ __('ui.bonuses.form.play_url_help') }}</span>
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.terms_url') }}</label>
            <input type="url" name="terms_url" value="{{ old('terms_url', $bonus->terms_url ?? '') }}">
        </div>
    </div>
</div>

<div class="form-section">
    <h3>{{ __('ui.bonuses.form.backside') }}</h3>
    <div class="grid grid-2">
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.back_text') }}</label>
            <textarea name="back_text" rows="4" placeholder="{{ __('ui.bonuses.form.placeholders.back_text') }}">{{ old('back_text', $bonus->back_text ?? '') }}</textarea>
            <span class="form-help">{{ __('ui.bonuses.form.back_text_help') }}</span>
        </div>
        <div class="form-group">
            <label>{{ __('ui.bonuses.form.payment_methods') }}</label>
            <input type="text" name="payment_methods" value="{{ old('payment_methods', $bonus->payment_methods ?? '') }}" placeholder="{{ __('ui.bonuses.form.placeholders.payment_methods') }}">
            <span class="form-help">{{ __('ui.bonuses.form.payment_methods_help') }}</span>
        </div>
    </div>
</div>

<div class="form-section">
    <h3>{{ __('ui.bonuses.form.visibility') }}</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $bonus->is_active ?? true) ? 'checked' : '' }}> {{ __('ui.bonuses.form.is_active') }}</label>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $bonus->is_featured ?? false) ? 'checked' : '' }}> {{ __('ui.bonuses.form.is_featured') }}</label>
        </div>
    </div>
</div>

<div class="form-section">
    <h3>{{ __('ui.bonuses.form.filters') }}</h3>
    <div class="checkbox-grid">
        @foreach($options as $option)
            <label class="checkbox-pill">
                <input type="checkbox" name="filter_options[]" value="{{ $option->id }}"
                    {{ in_array($option->id, old('filter_options', $selectedOptions ?? [])) ? 'checked' : '' }}>
                {{ $option->name }}
            </label>
        @endforeach
    </div>
</div>

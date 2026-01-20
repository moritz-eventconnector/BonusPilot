<div class="form-section">
    <h3>Basisdaten</h3>
    <div class="grid grid-2">
        <div class="form-group">
            <label>Bonus Title</label>
            <input type="text" name="title" value="{{ old('title', $bonus->title ?? '') }}" required>
        </div>
        <div class="form-group">
            <label>Casino/Brand Name</label>
            <input type="text" name="casino_name" value="{{ old('casino_name', $bonus->casino_name ?? '') }}">
        </div>
        <div class="form-group">
            <label>Short Teaser</label>
            <input type="text" name="short_text" value="{{ old('short_text', $bonus->short_text ?? '') }}">
        </div>
        <div class="form-group">
            <label>Bonus Icon (shown on card)</label>
            <input type="file" name="bonus_icon" accept=".png,.jpg,.jpeg,.svg">
            @if(!empty($bonus?->bonus_icon_path))
                <div style="margin-top:8px;">
                    <img src="{{ route('bonus.icon', $bonus) }}" alt="Bonus icon" style="max-height:48px;">
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>Long Description</label>
        <textarea name="content" rows="4">{{ old('content', $bonus->content ?? '') }}</textarea>
    </div>
</div>

<div class="form-section">
    <h3>Bonuswerte</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label>Bonus Code</label>
            <input type="text" name="bonus_code" value="{{ old('bonus_code', $bonus->bonus_code ?? '') }}">
        </div>
        <div class="form-group">
            <label>Bonus Code Label (optional)</label>
            <input type="text" name="bonus_code_label" value="{{ old('bonus_code_label', $bonus->bonus_code_label ?? '') }}" placeholder="Code">
        </div>
        <div class="form-group">
            <label>Bonus Percentage</label>
            <input type="number" name="bonus_percent" value="{{ old('bonus_percent', $bonus->bonus_percent ?? '') }}">
        </div>
        <div class="form-group">
            <label>Max Bonus Amount</label>
            <input type="text" name="max_bonus" value="{{ old('max_bonus', $bonus->max_bonus ?? '') }}">
        </div>
        <div class="form-group">
            <label>Max Bet</label>
            <input type="text" name="max_bet" value="{{ old('max_bet', $bonus->max_bet ?? '') }}">
        </div>
        <div class="form-group">
            <label>Wagering Requirement</label>
            <input type="text" name="wager" value="{{ old('wager', $bonus->wager ?? '') }}">
        </div>
        <div class="form-group">
            <label>Free Spins</label>
            <input type="text" name="free_spins" value="{{ old('free_spins', $bonus->free_spins ?? '') }}">
        </div>
    </div>
</div>

<div class="form-section">
    <h3>Label-Texte</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label>Bonus Percentage Label</label>
            <input type="text" name="bonus_percent_label" value="{{ old('bonus_percent_label', $bonus->bonus_percent_label ?? '') }}" placeholder="Bonus / Non-Sticky">
        </div>
        <div class="form-group">
            <label>Max Bonus Label</label>
            <input type="text" name="max_bonus_label" value="{{ old('max_bonus_label', $bonus->max_bonus_label ?? '') }}" placeholder="Maxbonus">
        </div>
        <div class="form-group">
            <label>Max Bet Label</label>
            <input type="text" name="max_bet_label" value="{{ old('max_bet_label', $bonus->max_bet_label ?? '') }}" placeholder="Maxbet">
        </div>
        <div class="form-group">
            <label>Wager Label (B+D)</label>
            <input type="text" name="wager_label" value="{{ old('wager_label', $bonus->wager_label ?? '') }}" placeholder="Wager (B+D)">
        </div>
    </div>
</div>

<div class="form-section">
    <h3>Links &amp; Call-to-Action</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label>CTA Button Text</label>
            <input type="text" name="cta_label" value="{{ old('cta_label', $bonus->cta_label ?? '') }}" placeholder="Claim Bonus">
        </div>
        <div class="form-group">
            <label>Play Link (URL)</label>
            <input type="url" name="play_url" value="{{ old('play_url', $bonus->play_url ?? '') }}">
        </div>
        <div class="form-group">
            <label>Terms Link (URL)</label>
            <input type="url" name="terms_url" value="{{ old('terms_url', $bonus->terms_url ?? '') }}">
        </div>
    </div>
</div>

<div class="form-section">
    <h3>Backseite &amp; Zahlungsarten</h3>
    <div class="grid grid-2">
        <div class="form-group">
            <label>Back Side Bullet Points</label>
            <textarea name="back_text" rows="4" placeholder="Extra details shown on the back of the card.">{{ old('back_text', $bonus->back_text ?? '') }}</textarea>
        </div>
        <div class="form-group">
            <label>Payment Methods (comma-separated)</label>
            <input type="text" name="payment_methods" value="{{ old('payment_methods', $bonus->payment_methods ?? '') }}" placeholder="Visa, MasterCard, PayPal">
        </div>
    </div>
</div>

<div class="form-section">
    <h3>Sichtbarkeit &amp; Sortierung</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $bonus->sort_order ?? 0) }}">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $bonus->is_active ?? true) ? 'checked' : '' }}> Visible on site</label>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $bonus->is_featured ?? false) ? 'checked' : '' }}> Show flame badge</label>
        </div>
    </div>
</div>

<div class="form-section">
    <h3>Filter Options</h3>
    @foreach($groups as $group)
        <div class="filter-group">
            <strong>{{ $group->name }}</strong>
            <div>
                @foreach($group->options as $option)
                    <label style="margin-right:12px;">
                        <input type="checkbox" name="filter_options[]" value="{{ $option->id }}"
                            {{ in_array($option->id, old('filter_options', $selectedOptions ?? [])) ? 'checked' : '' }}>
                        {{ $option->name }}
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

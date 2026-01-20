<div class="form-section">
    <h3>Basisdaten</h3>
    <div class="grid grid-2">
        <div class="form-group">
            <label>Bonus Titel</label>
            <input type="text" name="title" value="{{ old('title', $bonus->title ?? '') }}" required>
            <span class="form-help">Interner Name für die Anzeige auf der Karte.</span>
        </div>
        <div class="form-group">
            <label>Casino/Brand Name</label>
            <input type="text" name="casino_name" value="{{ old('casino_name', $bonus->casino_name ?? '') }}">
            <span class="form-help">Optional, wenn sich der Markenname vom Titel unterscheidet.</span>
        </div>
        <div class="form-group">
            <label>Kurzer Teaser</label>
            <input type="text" name="short_text" value="{{ old('short_text', $bonus->short_text ?? '') }}">
            <span class="form-help">Ein Satz für die Vorderseite (max. 1 Zeile).</span>
        </div>
        <div class="form-group">
            <label>Bonus Icon (auf der Karte)</label>
            <input type="file" name="bonus_icon" accept=".png,.jpg,.jpeg,.svg">
            @if(!empty($bonus?->bonus_icon_path))
                <div style="margin-top:8px;">
                    <img src="{{ route('bonus.icon', $bonus) }}" alt="Bonus icon" style="max-height:48px;">
                </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        <label>Beschreibung</label>
        <textarea name="content" rows="4">{{ old('content', $bonus->content ?? '') }}</textarea>
        <span class="form-help">Längere Beschreibung für die Detailseite.</span>
    </div>
</div>

<div class="form-section">
    <h3>Bonuswerte</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label>Promo Code</label>
            <input type="text" name="bonus_code" value="{{ old('bonus_code', $bonus->bonus_code ?? '') }}">
            <span class="form-help">Leer lassen, wenn kein Code benötigt wird.</span>
        </div>
        <div class="form-group">
            <label>Promo Code Label</label>
            <input type="text" name="bonus_code_label" value="{{ old('bonus_code_label', $bonus->bonus_code_label ?? '') }}" placeholder="Code">
            <span class="form-help">Zum Beispiel „Code“ oder „Bonuscode“.</span>
        </div>
        <div class="form-group">
            <label>Bonus Prozent</label>
            <input type="number" name="bonus_percent" value="{{ old('bonus_percent', $bonus->bonus_percent ?? '') }}">
        </div>
        <div class="form-group">
            <label>Max. Bonus Betrag</label>
            <input type="text" name="max_bonus" value="{{ old('max_bonus', $bonus->max_bonus ?? '') }}">
        </div>
        <div class="form-group">
            <label>Max. Einsatz</label>
            <input type="text" name="max_bet" value="{{ old('max_bet', $bonus->max_bet ?? '') }}">
        </div>
        <div class="form-group">
            <label>Wagering</label>
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
            <label>Label für Bonus</label>
            <input type="text" name="bonus_percent_label" value="{{ old('bonus_percent_label', $bonus->bonus_percent_label ?? '') }}" placeholder="Bonus / Non-Sticky">
        </div>
        <div class="form-group">
            <label>Label für Max. Bonus</label>
            <input type="text" name="max_bonus_label" value="{{ old('max_bonus_label', $bonus->max_bonus_label ?? '') }}" placeholder="Maxbonus">
        </div>
        <div class="form-group">
            <label>Label für Max. Einsatz</label>
            <input type="text" name="max_bet_label" value="{{ old('max_bet_label', $bonus->max_bet_label ?? '') }}" placeholder="Maxbet">
        </div>
        <div class="form-group">
            <label>Label für Wager</label>
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
            <span class="form-help">Wird für den „Play now“-Button genutzt.</span>
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
            <span class="form-help">Jede Zeile wird als eigener Bullet Point angezeigt.</span>
        </div>
        <div class="form-group">
            <label>Payment Methods (comma-separated)</label>
            <input type="text" name="payment_methods" value="{{ old('payment_methods', $bonus->payment_methods ?? '') }}" placeholder="Visa, MasterCard, PayPal">
            <span class="form-help">Kommagetrennt, z. B. Visa, MasterCard, PayPal.</span>
        </div>
    </div>
</div>

<div class="form-section">
    <h3>Sichtbarkeit &amp; Sortierung</h3>
    <div class="grid grid-3">
        <div class="form-group">
            <label>Sortierung</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $bonus->sort_order ?? 0) }}">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $bonus->is_active ?? true) ? 'checked' : '' }}> Sichtbar auf der Website</label>
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $bonus->is_featured ?? false) ? 'checked' : '' }}> Highlight mit Flame</label>
        </div>
    </div>
    <div class="form-note" style="margin-top:12px;">
        Tipp: Ein kleiner Sortierungswert bringt den Bonus weiter nach oben.
    </div>
</div>

<div class="form-section">
    <h3>Filter Optionen</h3>
    @foreach($groups as $group)
        <div class="filter-group">
            <strong>{{ $group->name }}</strong>
            <div class="checkbox-grid">
                @foreach($group->options as $option)
                    <label class="checkbox-pill">
                        <input type="checkbox" name="filter_options[]" value="{{ $option->id }}"
                            {{ in_array($option->id, old('filter_options', $selectedOptions ?? [])) ? 'checked' : '' }}>
                        {{ $option->name }}
                    </label>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

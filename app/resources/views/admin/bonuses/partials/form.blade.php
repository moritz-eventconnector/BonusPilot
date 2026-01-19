<div class="form-group">
    <label>Title</label>
    <input type="text" name="title" value="{{ old('title', $bonus->title ?? '') }}" required>
</div>
<div class="form-group">
    <label>Casino Name</label>
    <input type="text" name="casino_name" value="{{ old('casino_name', $bonus->casino_name ?? '') }}">
</div>
<div class="form-group">
    <label>Short Text</label>
    <input type="text" name="short_text" value="{{ old('short_text', $bonus->short_text ?? '') }}">
</div>
<div class="form-group">
    <label>Content</label>
    <textarea name="content" rows="4">{{ old('content', $bonus->content ?? '') }}</textarea>
</div>
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
        <label>Bonus Percent</label>
        <input type="number" name="bonus_percent" value="{{ old('bonus_percent', $bonus->bonus_percent ?? '') }}">
    </div>
    <div class="form-group">
        <label>Max Bonus</label>
        <input type="text" name="max_bonus" value="{{ old('max_bonus', $bonus->max_bonus ?? '') }}">
    </div>
</div>
<div class="form-group">
    <label>Bonus Icon (PNG/JPG/SVG)</label>
    <input type="file" name="bonus_icon" accept=".png,.jpg,.jpeg,.svg">
    @if(!empty($bonus?->bonus_icon_path))
        <div style="margin-top:8px;">
            <img src="{{ asset('storage/' . $bonus->bonus_icon_path) }}" alt="Bonus icon" style="max-height:48px;">
        </div>
    @endif
</div>
<div class="grid grid-3">
    <div class="form-group">
        <label>Max Bet</label>
        <input type="text" name="max_bet" value="{{ old('max_bet', $bonus->max_bet ?? '') }}">
    </div>
    <div class="form-group">
        <label>Wager</label>
        <input type="text" name="wager" value="{{ old('wager', $bonus->wager ?? '') }}">
    </div>
    <div class="form-group">
        <label>Free Spins</label>
        <input type="text" name="free_spins" value="{{ old('free_spins', $bonus->free_spins ?? '') }}">
    </div>
</div>
<div class="grid grid-3">
    <div class="form-group">
        <label>CTA Button Label</label>
        <input type="text" name="cta_label" value="{{ old('cta_label', $bonus->cta_label ?? '') }}" placeholder="Claim Bonus">
    </div>
    <div class="form-group">
        <label>Play URL</label>
        <input type="url" name="play_url" value="{{ old('play_url', $bonus->play_url ?? '') }}">
    </div>
    <div class="form-group">
        <label>Terms URL</label>
        <input type="url" name="terms_url" value="{{ old('terms_url', $bonus->terms_url ?? '') }}">
    </div>
</div>
<div class="form-group">
    <label>Back Side Text</label>
    <textarea name="back_text" rows="3" placeholder="Extra details shown on the back of the card.">{{ old('back_text', $bonus->back_text ?? '') }}</textarea>
</div>
<div class="form-group">
    <label>Payment Methods (comma-separated)</label>
    <input type="text" name="payment_methods" value="{{ old('payment_methods', $bonus->payment_methods ?? '') }}" placeholder="Visa, MasterCard, PayPal">
</div>
<div class="grid grid-3">
    <div class="form-group">
        <label>Sort Order</label>
        <input type="number" name="sort_order" value="{{ old('sort_order', $bonus->sort_order ?? 0) }}">
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="is_active" value="1" {{ old('is_active', $bonus->is_active ?? true) ? 'checked' : '' }}> Active</label>
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $bonus->is_featured ?? false) ? 'checked' : '' }}> Featured</label>
    </div>
</div>

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

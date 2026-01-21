<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bonus extends Model
{
    use HasFactory;

    public const PAYMENT_METHODS = [
        'Visa',
        'MasterCard',
        'PayPal',
        'Skrill',
        'Bitcoin',
        'Litecoin',
        'Ethereum',
        'Paysafecard',
        'Sofort',
    ];

    protected $fillable = [
        'title',
        'slug',
        'casino_name',
        'short_text',
        'bonus_code',
        'bonus_code_label',
        'bonus_percent',
        'bonus_percent_label',
        'max_bonus',
        'max_bonus_label',
        'max_bet',
        'max_bet_label',
        'wager',
        'wager_label',
        'free_spins',
        'cta_label',
        'play_url',
        'terms_url',
        'back_text',
        'payment_methods',
        'go_back_label',
        'bonus_icon_path',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'bonus_percent' => 'integer',
        'sort_order' => 'integer',
    ];

    public function paymentMethodsList(): array
    {
        if (!$this->payment_methods) {
            return [];
        }

        if (is_array($this->payment_methods)) {
            return array_values(array_filter($this->payment_methods));
        }

        $decoded = json_decode($this->payment_methods, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return array_values(array_filter($decoded));
        }

        return array_values(array_filter(array_map('trim', explode(',', $this->payment_methods))));
    }

    public function filterOptions(): BelongsToMany
    {
        return $this->belongsToMany(FilterOption::class);
    }
}

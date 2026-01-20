<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bonus extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'casino_name',
        'short_text',
        'content',
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

    public function filterOptions(): BelongsToMany
    {
        return $this->belongsToMany(FilterOption::class);
    }
}

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
        'bonus_percent',
        'max_bonus',
        'max_bet',
        'wager',
        'free_spins',
        'cta_label',
        'play_url',
        'terms_url',
        'back_text',
        'payment_methods',
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

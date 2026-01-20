<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'visited_at',
        'path',
        'referrer_host',
        'referrer_url',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'user_agent',
    ];
}

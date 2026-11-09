<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'address',
        'latitude',
        'longitude',
        'phone',
        'opening_time',
        'closing_time',
        'image',
        'is_open',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_open' => 'boolean',
            'rating' => 'float',
        ];
    }

    public function isCurrentlyOpen(): bool
    {
        if (!$this->opening_time || !$this->closing_time) {
            return false;
        }

        $now = now(config('app.timezone'))->format('H:i:s');

        $opening = $this->opening_time;
        $closing = $this->closing_time;

        if ($opening === $closing) {
            return false;
        }

        if ($opening < $closing) {
            return $now >= $opening && $now < $closing;
        }

        return $now >= $opening || $now < $closing;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

}

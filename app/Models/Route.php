<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Route extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'description',
        'direction',
    ];

    public function stations(): BelongsToMany
    {
        return $this->belongsToMany(Station::class, 'route_stations', 'route_id', 'station_id')->withPivot('route_id', 'station_id', 'time');
    }

    protected function acsrDirection(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $text = $attributes['direction'] ? ucwords(Str::replace('_', ' ', $attributes['direction'])) : 'N/A';
                $color = '#4b5563';
                if ($attributes['direction'] === 'clockwise') {
                    $color = '#16a34a';
                } else {
                    $color = '#2563eb';
                }

                return [
                    'text' => $text,
                    'color' => $color
                ];
            },
        );
    }
}

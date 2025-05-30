<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TicketPricing extends Model
{
    protected $fillable = [
        'type',
        'price',
        'offer_quantity',
        'remain_quantity',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    protected function acsrType(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $text = $attributes['type'] ? ucwords(Str::replace('_', ' ', $attributes['type'])) : '';
                $color = '#4b5563';
                if ($attributes['type'] === 'one_time_ticket') {
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

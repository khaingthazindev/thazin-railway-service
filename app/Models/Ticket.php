<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'ticket_pricing_id',
        'type',
        'direction',
        'price',
        'valid_at',
        'expire_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function ticket_pricing()
    {
        return $this->belongsTo(TicketPricing::class, 'ticket_pricing_id', 'id');
    }

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

    protected function acsrDirection(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $text = $attributes['direction'] ? ucwords(Str::replace('_', ' ', $attributes['direction'])) : '';

                switch ($attributes['direction']) {
                    case 'clockwise':
                        $color = '#16a34a';
                        break;
                    case 'anti_clockwise':
                        $color = '#2563eb';
                        break;
                    case 'both':
                        $color = '#4b5563';
                        break;
                    default:
                        $color = '#4b5563';
                }

                return [
                    'text' => $text,
                    'color' => $color
                ];
            },
        );
    }
}

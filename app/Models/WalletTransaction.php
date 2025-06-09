<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WalletTransaction extends Model
{
    protected $fillable = [
        'trx_id',
        'wallet_id',
        'user_id',
        'sourceable_id',
        'sourceable_type',
        'method',
        'type',
        'amount',
        'description',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sourceable()
    {
        return $this->morphTo();
    }

    protected function method(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                $text = $value ? ucfirst($value) : '';
                $color = '#4b5563';
                if ($value === 'add') {
                    $color = '#16a34a';
                    $sign = '+';
                } else {
                    $color = '#dc2626';
                    $sign = '-';
                }

                return [
                    'text' => $text,
                    'color' => $color,
                    'sign' => $sign
                ];
            },
        );
    }

    protected function type(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                $text = $value ? ucfirst(str_replace('_', '', $value)) : '';
                $color = '';
                $icon = '';
                switch ($value) {
                    case 'manual':
                        $color = '#f59e0b';
                        $icon = asset('image/transaction.png');
                        break;
                    case 'top_up':
                        $color = '#2563eb';
                        $icon = asset('image/topup.png');
                        break;
                    case 'buy_ticket':
                        $color = '#059669';
                        $icon = asset('image/buy_ticket.png');
                        break;
                    default:
                        $color = '#4b5563';
                        $icon = asset('image/transaction.png');
                        break;
                }

                return [
                    'text' => $text,
                    'color' => $color,
                    'icon' => $icon,
                ];
            },
        );
    }

    protected function from(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['method']) {
                    case 'add':
                        $text = $this->type['text'] . ($this->sourceable ? '(#' . $this->sourceable->id . ')' : '');
                        break;
                    case 'reduce':
                        $text = $this->user->name;
                        break;
                    default:
                        $text = '#4b5563';
                        break;
                }

                return [
                    'text' => $text
                ];
            },
        );
    }

    protected function to(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                switch ($attributes['method']) {
                    case 'add':
                        $text = $this->user->name;
                        break;
                    case 'reduce':
                        $text = $this->type['text'] . ($this->sourceable ? '(#' . $this->sourceable->id . ')' : '');
                        break;
                    default:
                        $text = '#4b5563';
                        break;
                }

                return [
                    'text' => $text
                ];
            },
        );
    }
}

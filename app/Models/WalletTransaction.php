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
                } else {
                    $color = '#dc2626';
                }

                return [
                    'text' => $text,
                    'color' => $color
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
                switch ($value) {
                    case 'manual':
                        $color = '#f59e0b';
                        break;
                    case 'top_up':
                        $color = '#2563eb';
                        break;
                    case 'buy_ticket':
                        $color = '#059669';
                        break;
                    default:
                        $color = '#4b5563';
                        break;
                }

                return [
                    'text' => $text,
                    'color' => $color
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

<?php

namespace App\Models;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TopUpHistory extends Model
{
    protected $fillable = [
        'trx_id',
        'wallet_id',
        'user_id',
        'amount',
        'description',
        'image',
        'status',
        'approved_at',
        'rejected_at',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function (string $value) {
                $text = $value ? ucfirst(str_replace('_', '', $value)) : '';
                $color = '';
                switch ($value) {
                    case 'pending':
                        $color = '#ea580c';
                        break;
                    case 'approved':
                        $color = '#16a34a';
                        break;
                    case 'rejected':
                        $color = '#dc2626';
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
}

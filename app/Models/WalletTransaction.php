<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'user_id',
        'sourceable_id',
        'sourceable_type',
        'method',
        'type',
        'amount',
        'description',
    ];
}

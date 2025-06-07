<?php

namespace App\Http\Resources\UserPortal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trx_id' => $this->trx_id,
            'amount' => number_format($this->amount) . ' MMK',
            'method' => $this->method,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'icon' => $this->type['icon']
        ];
    }
}

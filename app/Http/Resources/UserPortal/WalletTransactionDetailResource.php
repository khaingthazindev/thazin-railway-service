<?php

namespace App\Http\Resources\UserPortal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletTransactionDetailResource extends JsonResource
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
            'from' => $this->from['text'],
            'to' => $this->to['text'],
            'type' => $this->type,
            'method' => $this->method,
            'amount' => number_format($this->amount) . ' MMK',
            'created_at' => $this->created_at->format('d/m/Y H:i'),
            'description' => $this->description,
        ];
    }
}

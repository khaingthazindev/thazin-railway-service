<?php

namespace App\Http\Resources\UserPortal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopUpHistoryDetailResource extends JsonResource
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
            'user_text' => $this->user ? "{$this->user->name} ({$this->user->email})" : '',
            'amount' => number_format($this->amount) . ' MMK',
            'description' => $this->description,
            'status' => $this->acsr_status,
            'approved_at' => $this->approved_at ? $this->approved_at->format('Y-m-d H:i:s') : '',
            'rejected_at' => $this->rejected_at ? $this->rejected_at->format('Y-m-d H:i:s') : '',
            'image' => $this->imageUrl,
            'created_at' => $this->created_at->format('d/m/Y H:i'),
        ];
    }
}

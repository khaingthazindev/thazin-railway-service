<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => Str::limit($this->description, 100),
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'icon' => asset('image/station.png'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

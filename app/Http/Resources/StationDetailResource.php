<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StationDetailResource extends JsonResource
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
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'clockwise_schedules' => RouteScheduleOfStationResource::collection($this->routes->where('direction', 'clockwise')->sortBy('pivot.time')),
            'anti_clockwise_schedules' => RouteScheduleOfStationResource::collection($this->routes->where('direction', 'anti_clockwise')->sortBy('pivot.time')),
        ];
    }
}

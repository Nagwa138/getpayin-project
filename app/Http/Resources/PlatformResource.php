<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatformResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'color' => $this->color,
            'is_active' => auth()->user()->activePlatforms()->where('platform_id', $this->id)->exists(),
            'created_at' => $this->created_at->toIso8601String()
        ];
    }
}

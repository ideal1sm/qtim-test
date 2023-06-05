<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'preview_image' => asset($this->preview_image),
            'detail_image' => asset($this->detail_image),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'active' => $this->active
        ];
    }
}

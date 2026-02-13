<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'status' => $this->status,
            'type' => $this->type,
            'is_featured' => $this->is_featured,
            'order' => $this->order,
            'github_url' => $this->github_url,
            'demo_url' => $this->demo_url,
            'date_realisation' => $this->date_realisation
                ? \Carbon\Carbon::parse($this->date_realisation)->format('d/m/Y')
                : null,

            'author' => $this->when($this->relationLoaded('author'), [
                'id' => $this->author->id ?? null,
                'name' => $this->author->name ?? null,
            ]),

            'technologies' => TechnologyResource::collection($this->whenLoaded('technologies')),
            'images' => ImageResource::collection($this->whenLoaded('images')),
        ];
    }
}

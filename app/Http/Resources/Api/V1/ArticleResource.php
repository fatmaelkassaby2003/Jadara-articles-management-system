<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'cover_image' => $this->cover_image ? asset('storage/' . $this->cover_image) : null,
            'status' => $this->status,
            'reading_time' => $this->reading_time . ' دقيقة',
            'views_count' => $this->views_count,
            'published_at' => $this->published_at?->format('Y-m-d H:i'),
            'author' => new UserResource($this->whenLoaded('user')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}

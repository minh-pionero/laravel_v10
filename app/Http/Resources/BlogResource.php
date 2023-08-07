<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'categoryId' => $this->category_id,
            'title' => $this->title,
            'thumbnail' => $this->thumbnail,
            'shortDescription' => $this->short_description,
            'content' => $this->content,
            'isDraft' => $this->is_draft,
            'isDelete' => $this->is_delete,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}

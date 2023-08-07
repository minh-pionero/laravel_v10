<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'price' => (float) $this->price,
            'thumbnail' => $this->thumbnail,
            'images' => $this->images,
            'shortDescription' => $this->short_description,
            'description' => $this->description,
            'properties' => $this->properties,
            'source' => $this->source,
            'previewSourceUrl' => $this->preview_source_url,
            'isVirtualProduct' => (bool) $this->is_virtual_product,
            'isActive' => (bool) $this->is_active,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}

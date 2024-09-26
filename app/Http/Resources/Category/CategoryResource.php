<?php

namespace App\Http\Resources\Category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<CategoryResource>
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /**
             * @var int $id The id of the category
             */
            'id' => $this->id,
            /**
             * @var string $name The name of the category
             */
            'name' => $this->name,
            /**
             * @var string $slug The slug of the category
             */
            'slug' => $this->slug,
        ];
    }
}

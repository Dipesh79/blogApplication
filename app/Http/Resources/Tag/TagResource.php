<?php

namespace App\Http\Resources\Tag;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<TagResource>
 * @property int $id
 * @property string $name
 * @property string $slug
 */
class TagResource extends JsonResource
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
             * @var int $id The id of the tag
             */
            'id' => $this->id,
            /**
             * @var string $name The name of the tag
             */
            'name' => $this->name,
            /**
             * @var string $slug The slug of the tag
             */
            'slug' => $this->slug,
        ];
    }
}

<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<CommentResource>
 * @property int $id
 * @property string $content
 * @property UserResource $user
 */
class CommentResource extends JsonResource
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
             * @var int $id The id of the comment
             */
            'id' => $this->id,
            /**
             * @var string $content The content of the comment
             */
            'content' => $this->content,
            /**
             * @var string $user The user who created the comment
             */
            'user' => new UserResource($this->user),
        ];
    }
}

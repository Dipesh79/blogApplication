<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Tag\TagCollection;
use App\Http\Resources\Tag\TagResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<PostResource>
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property CategoryResource $category
 * @property UserResource $user
 * @property TagCollection $tags
 * @property CommentResource $comments
 */
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
            /**
             * @var int $id The id of the post
             */
            'id' => $this->id,
            /**
             * @var string $title The title of the post
             */
            'title' => $this->title,
            /**
             * @var string $slug The slug of the post
             */
            'slug' => $this->slug,
            /**
             * @var string $content The content of the post
             */
            'content' => $this->content,
            /**
             * @var int $category_id The category id of the post
             */
            'category' => new CategoryResource($this->category),
            /**
             * @var int $user_id The user id of the post
             */
            'user_id' => new UserResource($this->user),
            /**
             * @var int $tags.id The id of the tag
             */
            'tags' => TagResource::collection($this->tags),
            /**
             * @var int $comments The comments of the post
             */
            'comments' => CommentResource::collection($this->comments),
        ];
    }
}

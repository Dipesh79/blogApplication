<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @extends JsonResource<UserResource>
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $token
 *
 */
class UserResource extends JsonResource
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
             * @var int $id The id of the user
             */
            'id' => $this->id,
            /**
             * @var string $name The name of the user
             */
            'name' => $this->name,
            /**
             * @var string $email The email of the user
             */
            'email' => $this->email,
            /**
             * @var string $token The token of the user
             */
            'token' => $this->token ?? null
        ];
    }
}

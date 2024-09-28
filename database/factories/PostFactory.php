<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'slug' => $this->faker->slug,
            'content' => $this->faker->paragraph,
            'category_id' => $this->faker->randomElement(Category::pluck('id')->toArray()),
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray())
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Post $post) {
            $post->tags()->attach($this->faker->randomElements(Tag::pluck('id')->toArray(), 2));
        });

    }
}

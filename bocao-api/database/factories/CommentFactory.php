<?php

use App\Models\Comment;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence,
            'user_id' => User::factory(),
            'restaurant_id' => Restaurant::factory(),
        ];
    }
}

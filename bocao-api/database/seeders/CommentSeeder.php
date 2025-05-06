<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Restaurant;

class CommentSeeder extends Seeder
{
    public function run()
    {
        $users = User::factory(5)->create();

        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            foreach ($users as $user) {
                Comment::create([
                    'user_id' => $user->id,
                    'restaurant_id' => $restaurant->id,
                    'content' => fake()->sentence(), 
                ]);
            }
        }
    }
}
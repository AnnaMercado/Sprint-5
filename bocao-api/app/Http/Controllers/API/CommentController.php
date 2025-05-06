<?php
namespace App\Http\Controllers\API;

use App\Models\Restaurant;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function create(Request $request, $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        $validated = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $comment = Comment::create([
            'content' => $validated['content'],
            'user_id' => $request->user()->id,
            'restaurant_id' => $restaurant->id,
        ]);

        return new CommentResource($comment);
    }

    public function read(Request $request, $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        $comments = $restaurant->comments()->latest()->get();

        return CommentResource::collection($comments);
    }
}

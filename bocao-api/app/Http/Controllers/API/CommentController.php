<?php

namespace App\Http\Controllers\API;

use App\Models\Restaurant;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Services\RoleService;

class CommentController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }


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


    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $user = $request->user();

        if (!$this->roleService->canUpdateComment($user, $comment)) {
            return response()->json([
                'message' => 'Unauthorized to update this comment',
            ], 403);
        }

        $validated = $request->validate([
            'content' => ['required', 'string', 'max:255'], 
        ]);

        $comment->update($validated);

        return response()->json([
            'message' => 'Comment updated',
            'data' => $comment,
        ], 200);
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'content' => $this->content,
            'restaurant_id' => $this->restaurant_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
        ];

        if ($request->user() && $request->user()->hasRole('admin')) {
            $data['user'] = [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ];
        }

        return $data;
    }
}

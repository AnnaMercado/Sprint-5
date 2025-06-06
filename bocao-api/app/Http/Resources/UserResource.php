<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
        
        // Include roles if the requesting user is admin
        if ($request->user() && $request->user()->hasRole('admin')) {
            $data['roles'] = $this->getRoleNames()->toArray();
        }
        
        return $data;
    }
}
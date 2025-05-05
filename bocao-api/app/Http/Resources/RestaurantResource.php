<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($request->user() && $request->user()->hasRole('admin')) {
            $data['user'] = [
                'id' => $this->admin->id,  
                'name' => $this->admin->name,
                'email' => $this->admin->email,
            ];
        }

        return $data;
    }
}

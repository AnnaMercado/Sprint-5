<?php

namespace App\Http\Controllers\API;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\RestaurantResource;
use App\Services\RoleService;

class RestaurantController extends Controller
{

    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15', 'unique:restaurants'],
        ]);

        if (!$request->user() || !$request->user()->hasRole('admin')) {
            return response()->json([
                'message' => 'Only admins can create restaurants.',
            ], 403);
        }

        $restaurant = Restaurant::create([
            'name' => $validatedData['name'],
            'address' => $validatedData['address'],
            'phone' => $validatedData['phone'],
            'user_id' => $request->user()->id, 
        ]);

        return response()->json([
            'data' => new RestaurantResource($restaurant),
        ], 201);
    }

    public function read(Request $request)
    {
        return RestaurantResource::collection(Restaurant::all());
    }

    public function show(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return new RestaurantResource($restaurant);
    }

    public function update(Request $request, $id)
    {
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'message' => 'Only admin can access.',
            ], 403);
        }

        $restaurant = Restaurant::findOrFail($id);

        $validated = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'address' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'string', 'max:255', 'unique:restaurants,phone,' . $restaurant->id],
        ]);

        $restaurant->update($validated);

        return new RestaurantResource($restaurant);
    }

    public function delete(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);
    
        if (!$request->user()->hasRole('admin')) {
            return response()->json([
                'message' => 'Only admin can access.',
            ], 403);
        }
    
        $restaurant->delete();
    
        return response()->json(null, 204);
    }


    public function filter(Request $request)
    {
        $query = Restaurant::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%' . $request->input('phone') . '%');
        }

        $perPage = $request->input('per_page', 10);

        $restaurants = $query->paginate($perPage);

        return RestaurantResource::collection($restaurants);
    }
        
}


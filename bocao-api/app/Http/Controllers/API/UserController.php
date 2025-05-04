<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Services\RoleService;

class UserController extends Controller
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);

        $user->assignRole('user');

        $token = $user->createToken('auth_token')->accessToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
        ], 201);
    }
    public function read(Request $request)
    {
        if ($this->roleService->canViewAllUsers($request->user())) {
            return UserResource::collection(User::all());
        }
        
        return UserResource::collection(User::where('id', $request->user()->id)->get());
    }

 
    public function show(Request $request, $id)
    {
        $requestedUser = User::findOrFail($id);
        
        if ($this->roleService->canViewUserProfile($request->user(), $id)) {
            return new UserResource($requestedUser);
        }
        
        return response()->json([
            'message' => 'You have to be admin to access.',
        ], 403);
    }


}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\AuthUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //It Shows all users
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    //It Stores a new user
    public function store(StoreUserRequest  $request)
    {
        if ($request->validated()) {
            User::create($request->all());
            return response()->json(['message' => 'User Registered Successfully.'], 201);
        } else {
            return response()->json(['message' => 'Invalid user data.'], 400);
        }
    }

    //It Authenticates a user
    public function auth(AuthUserRequest $request){
        if ($request->validated()) {

            $user = User::whereEmail($request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 400);

            } else {
                return response()->json([
                    'user' => UserResource::make($user), // IMPORTANTE php artisan make:resource UserResource
                    'access-token' => $user->createToken('auth_token')->plainTextToken,
                ], 201);
            
        }
        }

        
    }

    //It Logs out a user
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.'], 200);
    }

    
}

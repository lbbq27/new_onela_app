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
    //It Shows all users ------------------------------------------------------
    public function index()
    {
        $users = User::all();
        //$users = User::select('id', 'name', 'email')->get();  // Select specific fields from the users table
        return response()->json($users);
    }




    //It Stores a new user  -------------------------------------------------------
    public function store(StoreUserRequest  $request)
    {
         if ($request->validated()) {
             User::create($request->all());
             return response()->json(['message' => 'User Registered Successfully.'], 201);
         } else {
             return response()->json(['message' => 'Invalid user data.'], 400);
         }

        //Another way to do it without validations: >>>>>>>>>>>>>>

        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        // ]);

        // return response()->json([
        //     'user' => $user->name,
        //     'email' => $user->email,
        // ]);

    }





    //It Authenticates a user -------------------------------------------------------
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

    //It shows a specific user by ID -------------------------------------------------------
    public function show(string $id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
    }

    
    }

    //It updates a specific user by ID -------------------------------------------------------
    public function update(Request $request, string $id){
        $user = User::find($id);
        if ($user) {
            $user->update($request->all());
            return response()->json(['message' => 'User updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'User not found.'], 404);
        }
    }

}

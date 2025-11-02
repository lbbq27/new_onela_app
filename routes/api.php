<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('user',[UserController::class, 'index']); //It shows all users
Route::post('user/register',[UserController::class, 'store']); //It stores a new user
Route::post('user/login',[UserController::class, 'auth']); //It authenticates a user
Route::post('user/logout',[UserController::class, 'logout'])->middleware('auth:sanctum'); //It logs out a user
Route::get('user/{id}', [UserController::class, 'show']); //It shows a specific user by ID
Route::put('user/{id}', [UserController::class, 'update']); //It updates a specific user by ID
Route::delete('user/{id}', [UserController::class, 'destroy']); //It deletes a specific user by ID



//Firts: php artisan install:api >> with this command we create the api auth system and sanctum config file
//Second: php artisan make:controller Api/UserController --api >> with this command we create the controller for the api
//Third : php artisan make:request StoreUserRequest >> with this command we create the request validation file
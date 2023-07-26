<?php

namespace App\Http\Controllers;

use App\Helpers\apiResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    //Implements CRUD operations for User

    public function index()
    {
       $users = User::with('posts')->get();
       return ApiResponse::success($users);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create($validatedData);
        return ApiResponse::success($user, 'User created successfully', 201);
    }

    public function show($id)
    {
        $user = User::with('posts')->find($id);
        if ($user) {
            return ApiResponse::success($user);
        } else {
            return ApiResponse::error('User not found', 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'required|string|min:8',
        ]);

        $user = User::find($id);
        if ($user) {
            $user->update($validatedData);
            return ApiResponse::success($user, 'User updated successfully');
        } else {
            return ApiResponse::error('User not found', 404);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return ApiResponse::success(null, 'User deleted successfully');
        } else {
            return ApiResponse::error('User not found', 404);
        }
    }
}

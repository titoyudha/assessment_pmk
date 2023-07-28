<?php

namespace App\Http\Controllers;

use App\Helpers\apiResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;


/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="User API",
 *      description="API endpoints for managing users",
 * )
 */
class UserController extends Controller
{
    /**
 * @OA\Get(
 *     path="/api/users",
 *     summary="Get all users",
 *     tags={"Users"},
 *     security={{ "apiToken": {} }},
 *     @OA\Response(
 *         response=200,
 *         description="List of users",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/UserResponse")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized. Token not provided or invalid.",
 *         @OA\JsonContent(ref="#/components/schemas/unauthorized")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(ref="#/components/schemas/internalServerError")
 *     ),
 * )
 */

/**
 * @OA\Post(
 *     path="/api/users",
 *     summary="Create a new user",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="User created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/UserResponse")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error. Invalid data provided.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", ref="#/components/schemas/errors")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(ref="#/components/schemas/internalServerError")
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     path="/api/users/{id}",
 *     summary="Get a specific user",
 *     tags={"Users"},
 *     security={{ "apiToken": {} }},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the user",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User details",
 *         @OA\JsonContent(ref="#/components/schemas/UserResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(ref="#/components/schemas/notFound")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized. Token not provided or invalid.",
 *         @OA\JsonContent(ref="#/components/schemas/unauthorized")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(ref="#/components/schemas/internalServerError")
 *     ),
 * )
 */

/**
 * @OA\Put(
 *     path="/api/users/{id}",
 *     summary="Update a user",
 *     tags={"Users"},
 *     security={{ "apiToken": {} }},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the user",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/UserResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(ref="#/components/schemas/notFound")
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error. Invalid data provided.",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="errors", ref="#/components/schemas/errors")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized. Token not provided or invalid.",
 *         @OA\JsonContent(ref="#/components/schemas/unauthorized")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(ref="#/components/schemas/internalServerError")
 *     ),
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/users/{id}",
 *     summary="Delete a user",
 *     tags={"Users"},
 *     security={{ "apiToken": {} }},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the user",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(ref="#/components/schemas/notFound")
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized. Token not provided or invalid.",
 *         @OA\JsonContent(ref="#/components/schemas/unauthorized")
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *         @OA\JsonContent(ref="#/components/schemas/internalServerError")
 *     ),
 * )
 */

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

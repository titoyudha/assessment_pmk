<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Helpers\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;

/**
 * @OA\Tag(
 *     name="posts",
 *     description="API endpoints for managing posts"
 * )
 */
class PostController extends Controller
{

    /**
 * @OA\Post(
 *     path="/api/posts",
 *     summary="Create a new post",
 *     tags={"Posts"},
 *     security={{ "apiToken": {} }},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/PostRequest")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Post created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/PostResponse")
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
 * @OA\Get(
 *     path="/api/posts/{id}",
 *     summary="Get a specific post",
 *     tags={"Posts"},
 *     security={{ "apiToken": {} }},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the post",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post details",
 *         @OA\JsonContent(ref="#/components/schemas/PostResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post not found",
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
 *     path="/api/posts/{id}",
 *     summary="Update a post",
 *     tags={"Posts"},
 *     security={{ "apiToken": {} }},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the post",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/PostRequest")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/PostResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post not found",
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
 *     path="/api/posts/{id}",
 *     summary="Delete a post",
 *     tags={"Posts"},
 *     security={{ "apiToken": {} }},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         description="ID of the post",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Post deleted successfully",
 *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Post not found",
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

    //Implements CRUD operations for post
    public function index()
    {
        $posts = Post::with('user')->get();
        return ApiResponse::success($posts);
    }


    public function show($id)
    {
        $post = Post::with('user')->find($id);
        if ($post) {
            return ApiResponse::success($post);
        } else {
            return ApiResponse::error('Post not found', 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = Post::find($id);
        if ($post) {
            $post->update($validatedData);
            return ApiResponse::success($post, 'Post updated successfully');
        } else {
            return ApiResponse::error('Post not found', 404);
        }
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->delete();
            return ApiResponse::success(null, 'Post deleted successfully');
        } else {
            return ApiResponse::error('Post not found', 404);
        }
    }
}

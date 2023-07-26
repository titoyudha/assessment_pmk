<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Helpers\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;

class PostController extends Controller
{
    //Implements CRUD operations for post
    public function index()
    {
        $posts = Post::with('user')->get();
        return ApiResponse::success($posts);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = Post::create($validatedData);
        return ApiResponse::success($post, 'Post created successfully', 201);
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

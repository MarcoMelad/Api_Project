<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ApiresponseTrait;

    public function index()
    {
        $posts = PostResource::collection(Post::get());
        return $this->apiResponse($posts, 'Success', 200);
    }

    public function show($id)
    {
        $post = Post::find($id);
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'Success', 200);
        }
        return $this->apiResponse(null, 'Not Found', 401);

    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'body' => 'required',
        ];
        $errorResponse = $this->validateRequest($request, $rules);
        if ($errorResponse) {
            return $errorResponse;
        }

        $post = Post::create($request->all());
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'Success', 201);
        }
        return $this->apiResponse(null, 'Not Created', 401);
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|max:255',
            'body' => 'required',
        ];
        $errorResponse = $this->validateRequest($request, $rules);
        if ($errorResponse) {
            return $errorResponse;
        }

        $post = Post::find($id);
        if (!$post){
            return $this->apiResponse(null, 'Post Not Found', 400);
        }
        $post->update($request->all());
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'Update', 201);
        }
    }
}

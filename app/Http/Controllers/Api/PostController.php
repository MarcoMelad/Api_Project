<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiresponseTrait;
    public function index()
    {
        $posts = PostResource::collection(Post::get());
        return $this->apiResponse($posts,'Success',200);
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
        $post = Post::create($request->all());
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'Success', 201);
        }
        return $this->apiResponse(null, 'Not Created', 400);
    }
}

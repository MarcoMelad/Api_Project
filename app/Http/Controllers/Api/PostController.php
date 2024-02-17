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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'body' => 'required',
        ]);
        if ($validator->fails()) {

            return $this->apiResponse(null, $validator->errors(), 400);
        }

        $post = Post::create($request->all());
        if ($post) {
            return $this->apiResponse(new PostResource($post), 'Success', 201);
        }
    }
}

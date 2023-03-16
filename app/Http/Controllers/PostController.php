<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = auth()->user();

        $post = $user->posts()->create($validator->validated());

        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'nullable',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post->update($validator->validated());

        return $post;
    }

    public function delete(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(['message' => 'Delete post successfully']);
    }
}

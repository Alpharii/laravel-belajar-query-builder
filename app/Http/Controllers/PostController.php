<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    // GET /posts
    public function index()
    {
        $posts = DB::table('posts')->get();
        return response()->json($posts);
    }

    public function show($id){
        $post = DB::table(table: 'posts')->get()->where('id', $id)->first();
        if(!$post){
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string'
        ]);

        $id = DB::table('posts')->insertGetId([
            'title' => $request->title,
            'content' => $request->content,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Post created', 'id' => $id], 201);
    }

    // PUT /posts/{id}
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string'
        ]);

        $updated = DB::table('posts')->where('id', $id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'updated_at' => now(),
        ]);

        if ($updated) {
            return response()->json(['message' => 'Post updated']);
        } else {
            return response()->json(['message' => 'Post not found or not changed'], 404);
        }
    }

    // DELETE /posts/{id}
    public function destroy($id)
    {
        $deleted = DB::table('posts')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Post deleted']);
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }
}

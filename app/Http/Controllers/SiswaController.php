<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    // GET /siswa
    public function index()
    {
        $siswa = DB::table('siswa')->get();
        return response()->json($siswa);
    }

    public function show($id){
        $post = DB::table(table: 'siswa')->get()->where('id', $id)->first();
        if(!$post){
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer',
            'kelas' => 'required|string|max:255',
        ]);

        $id = DB::table('siswa')->insertGetId([
            'nama' => $request->nama,
            'umur' => $request->umur,
            'kelas' => $request->kelas,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Post created', 'id' => $id], 201);
    }

    // PUT /siswa/{id}
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'kelas' => 'sometimes|required|string|max:255',
            'umur' => 'sometimes|required|integer'
        ]);

        $updated = DB::table('siswa')->where('id', $id)->update([
            'nama' => $request->nama,
            'umur' => $request->umur,
            'kelas' => $request->kelas,
            'updated_at' => now(),
        ]);

        if ($updated) {
            return response()->json(['message' => 'Post updated']);
        } else {
            return response()->json(['message' => 'Post not found or not changed'], 404);
        }
    }

    // DELETE /siswa/{id}
    public function destroy($id)
    {
        $deleted = DB::table('siswa')->where('id', $id)->delete();

        if ($deleted) {
            return response()->json(['message' => 'Post deleted']);
        } else {
            return response()->json(['message' => 'Post not found'], 404);
        }
    }
}

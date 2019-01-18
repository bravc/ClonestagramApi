<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            // get image from upload and attempt to upload
            $file = $request->file('image')->getRealPath();
            \Log::info($file);
            $result = \Cloudinary\Uploader::upload($file, []);

            // check if url was generated
            if (isset($result['secure_url'])) {
                $post = new Post;
                $post->description = $request->input('description');
                $post->image_url = $result['secure_url'];
                $post->save();
                return response()->json(['url' => $result['secure_url']], 201);
            } else {
                return response()->json(['error' => 'Failed to create image URL'], 400);
            }
        } else {
            return response()->json(['error' => 'No image provided'], 400);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $article = Post::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json('Resource destroyed', 204);
    }

    /**
     * Get all posts
     */
    public function getAll() {
        return response()->json(Post::orderByDesc('created_at')->get());
    }
}

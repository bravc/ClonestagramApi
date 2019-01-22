<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
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
    public function index(Request $request)
    {
        if ($request->user()->posts()->exists()) {
            return new PostCollection($request->user()->posts());
        }

        return response()->json([], 200);
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
        $post = new PostResource(Post::findOrFail($id));
        return $post;
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
        $post = Post::findOrFail($id);
        $post->update($request->all());

        return $post;
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
     * Add like to post
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addLike($id) {
        $post = Post::findOrFail($id);

        $post->likes = $post->likes + 1;
        $post->save();
    }

    /**
     * Remove like from post
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeLike($id) {
        $post = Post::findOrFail($id);

        $post->likes = $post->likes - 1;
        $post->save();
    }

    /**
     * Get comments of post
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function comments($id) {
        $post = Post::findOrFail($id);

        return $post->comments;
    }
}

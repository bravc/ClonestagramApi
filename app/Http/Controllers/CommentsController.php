<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Comment;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // find users comments
        if ($request->user()->comments()->exists()) {
            return $request->user()->comments;
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
            'post_id' => 'required|numeric',
            'text' => 'required|string'
        ]);

        $comment = new Comment;
        $comment->text = $request->input('text');
        $comment->post_id = (int) $request->input('post_id');
        $request->user()->comments()->save($comment);
        $comment->save();

        return response()->json('Stored', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Comment::findOrFail($id);
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
        $request->validate([
            'text' => 'required|string'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->all());

        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json('Resource destroyed', 204);
    }
}

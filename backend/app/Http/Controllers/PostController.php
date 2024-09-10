<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // Attempt to update the post with the validated data
            $post = Post::create([
                'userId' => $request->userid,
                'title' => $request->title,
                'body' => $request->body,
            ]);

            // Return a success response with the updated post
            return response()->json([
                'success' => true,
                'message' => 'Post created successfully',
                'post' => $post
            ], 200); // HTTP status code 200 for success
        } catch (\Exception $e) {
            // Return a failure response if an exception occurs
            return response()->json([
                'fail' => true,
                'message' => 'Failed to created post',
                'error' => $e->getMessage() // Include the exception message for debugging
            ], 500); // HTTP status code 500 for server error
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $posts = Post::find($post->id);
        return response()->json($posts);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {

        try {
            // Attempt to update the post with the validated data
            $post->update([
                'userId' => $request->userid,
                'title' => $request->title,
                'body' => $request->body,
            ]);

            // Return a success response with the updated post
            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'post' => $post
            ], 200); // HTTP status code 200 for success
        } catch (\Exception $e) {
            // Return a failure response if an exception occurs
            return response()->json([
                'fail' => true,
                'message' => 'Failed to update post',
                'error' => $e->getMessage() // Include the exception message for debugging
            ], 500); // HTTP status code 500 for server error
        }


        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {

        try {
            // Attempt to update the post with the validated data
            $posts = $post->delete();

            // Return a success response with the updated post
            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully',
                'post' => $post
            ], 200); // HTTP status code 200 for success
        } catch (\Exception $e) {
            // Return a failure response if an exception occurs
            return response()->json([
                'fail' => true,
                'message' => 'Failed to delete post',
                'error' => $e->getMessage() // Include the exception message for debugging
            ], 500); // HTTP status code 500 for server error
        }
    }
}

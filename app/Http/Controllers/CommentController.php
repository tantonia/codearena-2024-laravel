<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'body' => 'required|string|max:1000',
        ]);

        $post->comments()->create($validated);

        return redirect()->route('post', $post->slug)->with('success', 'Comment added successfully!');
    }

    public function show(Post $post, Comment $comment)
    {
        return view('posts.show', compact('post','comment'));
    }

    public function delete(Comment $comment)
    {
        $post = $comment->post; // Retrieve the related post using the relationship
        $comment->delete();

        return redirect()->route('post', $post->slug)
            ->with('success', 'Comment deleted successfully.');
    }
}

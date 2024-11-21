<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    public function index(User $user = null)
    {
        $posts = Post::when($user, function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->whereNotNull('published_at')
        ->whereNotNull('image')
        ->orderByDesc('promoted') // Promoted posts first
        ->orderByDesc('published_at')
        ->paginate(12);

        // Get authors who have published at least one post
        $authors = User::whereHas('posts', function ($query) {
            $query->whereNotNull('published_at');
        })->get();

        return view('posts.index', compact('posts', 'authors'));
    }

    public function show(Post $post)
    {
        // Check if the post is unpublished
        if (!$post->published_at) {
            abort(404); // Return a 404 response if unpublished
        }
        $comments = $post->comments()
        ->orderBy('created_at', 'desc')
        ->orderBy('id', 'desc')
        ->get();
        return view('posts.show', compact('post', 'comments'));
    }

    public function promoted()
    {
        $posts = Post::whereNotNull('published_at')
        ->where('promoted', true)
        ->orderByDesc('published_at')
        ->paginate(12);

        return view('posts.promoted', compact('posts'));
    }

    public function delete(Post $post, Comment $comment)
    {
        $comment->delete();

        // Redirect back to the associated post page
        return redirect()->route('post', $post->slug)
            ->with('success', 'Comment deleted successfully.');
    }
}

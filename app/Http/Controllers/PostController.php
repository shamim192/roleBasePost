<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $this->authorize('create-post');

        $posts = Post::all();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $this->authorize('create-post');

        return view('posts.create');
    }

    public function store(Request $request)
{
    $this->authorize('create-post');

    $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
    ]);

    try {
        $post = auth()->user()->posts()->create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'status' => 'pending_review',
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error creating post: ' . $e->getMessage());
    }
}

    public function edit(Post $post)
    {
        $this->authorize('edit-post', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('edit-post', $post);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete-post', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }

    public function submitForReview(Post $post)
    {
        $this->authorize('submit-review-post', $post);

        $post->update(['status' => 'pending_review']);

        return redirect()->route('posts.index')->with('success', 'Post submitted for review');
    }

    public function review(Post $post)
    {
        $this->authorize('review-post', $post);

        return view('posts.review', compact('post'));
    }

    public function approve(Post $post)
    {
        $this->authorize('review-post', $post);

        $post->update(['status' => 'approved']);

        return redirect()->route('dashboard')->with('success', 'Post approved');
    }

    public function reject(Post $post)
    {
        $this->authorize('review-post', $post);

        $post->update(['status' => 'rejected']);

        return redirect()->route('dashboard')->with('success', 'Post rejected');
    }
}

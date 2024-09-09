<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf'
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('files');
        }

        $validated['user_id'] = Auth::id();
        Post::create($validated);

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,png,pdf'
        ]);

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('files');
        }

        $post->update($validated);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean'
        ]);

        $data['slug'] = Str::slug($request->title);
        $data['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            $data['image'] = \App\Helpers\ImageHelper::processAndSave(
                $request->file('image'),
                'uploads/posts'
            );
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:100',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_published' => 'boolean'
        ]);

        $data['slug'] = Str::slug($request->title);
        $data['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($post->image) {
                \App\Helpers\ImageHelper::delete($post->image);
            }

            $data['image'] = \App\Helpers\ImageHelper::processAndSave(
                $request->file('image'),
                'uploads/posts'
            );
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            \App\Helpers\ImageHelper::delete($post->image);
        }
        
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $url = \App\Helpers\ImageHelper::processAndSave(
                $request->file('file'),
                'uploads/posts/content'
            );
            
            // If the URL doesn't start with http (local dev), wrap it with asset()
            $finalUrl = str_starts_with($url, 'http') ? $url : asset($url);

            return response()->json([
                'url' => $finalUrl
            ]);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}

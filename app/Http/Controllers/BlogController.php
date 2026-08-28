<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Post::where('is_published', true);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        $posts = $query->latest()->paginate(9);
        
        // Handle AJAX request for Load More
        if ($request->ajax()) {
            return view('blog.partials.post_grid', compact('posts'))->render();
        }

        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = \App\Models\Post::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $post->increment('views');

        // Generate Table of Contents using regex (safe for Summernote HTML)
        $toc = [];
        $content = $post->content;
        
        if ($content) {
            $usedIds = [];
            
            // Find all h2 and h3 tags and inject id attributes
            $content = preg_replace_callback(
                '/<(h[23])((?:\s[^>]*)?)>(.*?)<\/\1>/is',
                function ($matches) use (&$toc, &$usedIds) {
                    $tag = $matches[1]; // h2 or h3
                    $attrs = $matches[2]; // existing attributes
                    $text = strip_tags($matches[3]); // plain text content
                    $level = ($tag === 'h2') ? 2 : 3;
                    
                    // Check if id already exists in attributes
                    if (preg_match('/\bid=["\']([^"\']+)["\']/i', $attrs, $idMatch)) {
                        $id = $idMatch[1];
                    } else {
                        // Generate slug-based id
                        $id = \Illuminate\Support\Str::slug($text);
                        if (empty($id)) {
                            $id = 'heading-' . count($toc);
                        }
                        
                        // Prevent duplicate IDs
                        $originalId = $id;
                        $counter = 1;
                        while (in_array($id, $usedIds)) {
                            $id = $originalId . '-' . $counter;
                            $counter++;
                        }
                        
                        // Inject id attribute
                        $attrs = ' id="' . $id . '"' . $attrs;
                    }
                    
                    $usedIds[] = $id;
                    $toc[] = [
                        'level' => $level,
                        'id' => $id,
                        'title' => $text,
                    ];
                    
                    return '<' . $tag . $attrs . '>' . $matches[3] . '</' . $tag . '>';
                },
                $content
            );
            
            // Only update content if regex succeeded
            if ($content !== null) {
                $post->content = $content;
            }
        }
        
        return view('blog.show', compact('post', 'toc'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query()->published()->with('author:id,name')->latest('published_at');

        if ($search = trim((string) $request->query('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        $posts = $query->paginate(9)->withQueryString();

        $categories = Post::query()
            ->published()
            ->whereNotNull('category')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $recentPosts = Post::query()->published()->latest('published_at')->take(4)->get();

        return view('shop.blog.index', compact('posts', 'categories', 'recentPosts', 'search', 'category'));
    }

    public function show(string $slug)
    {
        $post = Post::query()
            ->published()
            ->with('author:id,name')
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views');

        $relatedPosts = Post::query()
            ->published()
            ->where('id', '!=', $post->id)
            ->when($post->category, fn ($q) => $q->where('category', $post->category))
            ->latest('published_at')
            ->take(3)
            ->get();

        $recentPosts = Post::query()->published()->latest('published_at')->take(4)->get();

        return view('shop.blog.show', compact('post', 'relatedPosts', 'recentPosts'));
    }
}

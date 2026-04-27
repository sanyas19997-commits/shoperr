<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 15);
        $query = Post::query()->with('author:id,name')->latest();

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            });
        }

        if ($request->filled('is_published')) {
            $query->where('is_published', (bool) $request->boolean('is_published'));
        }

        return $query->paginate($perPage);
    }

    public function show(Post $post)
    {
        return response()->json(['data' => $post->load('author:id,name')]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['author_id'] = $request->user()?->id;
        $post = Post::create($data);
        ActionLog::log('post.create', $post, $data);
        return response()->json(['data' => $post->fresh()->load('author:id,name')], 201);
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post);
        $post->update($data);
        ActionLog::log('post.update', $post, $data);
        return response()->json(['data' => $post->fresh()->load('author:id,name')]);
    }

    public function destroy(Request $request, Post $post)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        if ($post->image && ! str_starts_with($post->image, '/') && ! preg_match('#^https?://#i', $post->image)) {
            Storage::disk('public')->delete($post->image);
        }
        ActionLog::log('post.delete', $post);
        $post->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    private function validated(Request $request, ?Post $post = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:120'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'file', 'image', 'max:5120'],
            'image_path' => ['nullable', 'string'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']) . '-' . substr(uniqid(), -4);
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog', 'public');
        } elseif (! empty($data['image_path'])) {
            $data['image'] = $data['image_path'];
        }

        unset($data['image_path']);

        if (array_key_exists('is_published', $data)) {
            $data['is_published'] = (bool) $data['is_published'];
        }

        return $data;
    }
}

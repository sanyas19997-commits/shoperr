<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\InstagramPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstagramPostController extends Controller
{
    public function index(Request $request)
    {
        return InstagramPost::orderBy('sort_order')->paginate($request->integer('per_page', 50));
    }

    public function show(InstagramPost $instagramPost)
    {
        return response()->json(['data' => $instagramPost]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        if (empty($data['image'])) {
            return response()->json(['errors' => ['image' => ['Загрузите картинку']]], 422);
        }
        $post = InstagramPost::create($data);
        ActionLog::log('instagram.create', $post, $data);
        return response()->json(['data' => $post], 201);
    }

    public function update(Request $request, InstagramPost $instagramPost)
    {
        $data = $this->validated($request, $instagramPost);
        $instagramPost->update($data);
        ActionLog::log('instagram.update', $instagramPost, $data);
        return response()->json(['data' => $instagramPost->fresh()]);
    }

    public function destroy(Request $request, InstagramPost $instagramPost)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        ActionLog::log('instagram.delete', $instagramPost);
        $instagramPost->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    private function validated(Request $request, ?InstagramPost $p = null): array
    {
        $data = $request->validate([
            'link' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        if ($request->hasFile('image')) {
            if ($p && $p->image && !str_starts_with($p->image, 'kidify/')) {
                Storage::disk('public')->delete($p->image);
            }
            $data['image'] = $request->file('image')->store('instagram', 'public');
        }
        return $data;
    }
}

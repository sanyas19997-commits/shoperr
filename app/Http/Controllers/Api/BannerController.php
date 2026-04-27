<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $q = Banner::query();
        if ($place = $request->string('place')->toString()) {
            $q->where('place', $place);
        }
        return $q->orderBy('place')->orderBy('sort_order')->paginate($request->integer('per_page', 50));
    }

    public function show(Banner $banner)
    {
        return response()->json(['data' => $banner]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $banner = Banner::create($data);
        ActionLog::log('banner.create', $banner, $data);
        return response()->json(['data' => $banner], 201);
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $this->validated($request, $banner);
        $banner->update($data);
        ActionLog::log('banner.update', $banner, $data);
        return response()->json(['data' => $banner->fresh()]);
    }

    public function destroy(Request $request, Banner $banner)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        ActionLog::log('banner.delete', $banner);
        $banner->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    private function validated(Request $request, ?Banner $banner = null): array
    {
        $data = $request->validate([
            'place' => ['required', 'string', 'max:50'],
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'label' => ['nullable', 'string', 'max:255'],
            'price_label' => ['nullable', 'string', 'max:100'],
            'link' => ['nullable', 'string', 'max:500'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        if ($request->hasFile('image')) {
            if ($banner && $banner->image && !str_starts_with($banner->image, 'kidify/')) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }
        return $data;
    }
}

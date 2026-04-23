<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        return BannerResource::collection(Banner::orderBy('sort_order')->get());
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('image_file')) {
            $data['image'] = $request->file('image_file')->store('banners', 'public');
        }
        unset($data['image_file']);
        $banner = Banner::create($data);
        return new BannerResource($banner);
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('image_file')) {
            $data['image'] = $request->file('image_file')->store('banners', 'public');
        }
        unset($data['image_file']);
        if (array_key_exists('image', $data) && ($data['image'] === null || $data['image'] === '')) {
            // Don't null out the existing image on edits that omit the field.
            unset($data['image']);
        }
        $banner->update($data);
        return new BannerResource($banner);
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return response()->json(['message' => 'Удалено']);
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'image' => ['required_without:image_file', 'nullable', 'string', 'max:2000'],
            'image_file' => ['nullable', 'file', 'image', 'max:5120'],
            'url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}

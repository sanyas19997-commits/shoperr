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
        // On creation we need either an image URL or an uploaded file, because
        // the banner row has no existing image to fall back to.
        $data = $this->validateData($request, creating: true);
        if ($request->hasFile('image_file')) {
            $data['image'] = $request->file('image_file')->store('banners', 'public');
        }
        unset($data['image_file']);
        $banner = Banner::create($data);
        return new BannerResource($banner);
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $this->validateData($request, creating: false);
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

    protected function validateData(Request $request, bool $creating): array
    {
        // NOTE: we intentionally do NOT mark `image` as `nullable` on create.
        // Laravel short-circuits the rest of the rules (including
        // required_without) when a nullable field is null, which would let a
        // banner be inserted without any image and hit the NOT NULL column in
        // `banners.image`. On update the field is omitted from the rules
        // entirely via the `sometimes` gate below.
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'image_file' => ['nullable', 'file', 'image', 'max:5120'],
            'url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ];
        if ($creating) {
            $rules['image'] = ['required_without:image_file', 'string', 'max:2000'];
        } else {
            // Only validate `image` when the client actually sent it. This
            // keeps partial updates like `{sort_order: 3}` valid.
            $rules['image'] = ['sometimes', 'string', 'max:2000'];
        }
        return $request->validate($rules);
    }
}

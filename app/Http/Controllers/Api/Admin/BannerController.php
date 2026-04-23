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
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            // On create we require either an image URL or a file upload. On
            // update the banner already has an image, so both fields are
            // optional and the caller may patch only title / sort_order etc.
            'image' => array_filter([
                $creating ? 'required_without:image_file' : null,
                'nullable', 'string', 'max:2000',
            ]),
            'image_file' => ['nullable', 'file', 'image', 'max:5120'],
            'url' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}

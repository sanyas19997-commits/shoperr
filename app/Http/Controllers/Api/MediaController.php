<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'image', 'max:5120'],
            'folder' => ['nullable', 'string', 'in:products,categories,brands,settings,pages'],
        ]);

        $folder = $request->input('folder', 'products');
        $path = $request->file('file')->store($folder, 'public');

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate(['path' => ['required', 'string']]);
        Storage::disk('public')->delete($request->input('path'));
        return response()->json(['message' => 'Удалено.']);
    }
}

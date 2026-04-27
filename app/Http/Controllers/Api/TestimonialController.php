<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        return Testimonial::orderBy('sort_order')->paginate($request->integer('per_page', 50));
    }

    public function show(Testimonial $testimonial)
    {
        return response()->json(['data' => $testimonial]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $t = Testimonial::create($data);
        ActionLog::log('testimonial.create', $t, $data);
        return response()->json(['data' => $t], 201);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $this->validated($request, $testimonial);
        $testimonial->update($data);
        ActionLog::log('testimonial.update', $testimonial, $data);
        return response()->json(['data' => $testimonial->fresh()]);
    }

    public function destroy(Request $request, Testimonial $testimonial)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        ActionLog::log('testimonial.delete', $testimonial);
        $testimonial->delete();
        return response()->json(['message' => 'Удалено.']);
    }

    private function validated(Request $request, ?Testimonial $t = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'rating' => ['nullable', 'integer', 'min:1', 'max:5'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = (bool) ($data['is_active'] ?? false);
        if ($request->hasFile('avatar')) {
            if ($t && $t->avatar && !str_starts_with($t->avatar, 'kidify/')) {
                Storage::disk('public')->delete($t->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }
        return $data;
    }
}

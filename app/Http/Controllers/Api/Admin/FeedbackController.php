<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::query()->with('admin');

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('subject', 'like', "%$q%")
                    ->orWhere('message', 'like', "%$q%");
            });
        }

        return FeedbackResource::collection($query->latest()->paginate(20));
    }

    public function show(Feedback $feedback): FeedbackResource
    {
        if ($feedback->status === 'new') {
            $feedback->update(['status' => 'read']);
        }
        $feedback->load('admin');
        return new FeedbackResource($feedback);
    }

    public function update(Request $request, Feedback $feedback): FeedbackResource
    {
        $data = $request->validate([
            'status' => ['sometimes', Rule::in(Feedback::STATUSES)],
            'admin_reply' => ['sometimes', 'nullable', 'string', 'max:5000'],
        ]);

        if (array_key_exists('admin_reply', $data) && $data['admin_reply']) {
            $data['admin_id'] = $request->user()->id;
            $data['replied_at'] = now();
            if (!isset($data['status'])) {
                $data['status'] = 'answered';
            }
        }

        $feedback->update($data);
        $feedback->load('admin');
        return new FeedbackResource($feedback);
    }

    public function destroy(Feedback $feedback): JsonResponse
    {
        $feedback->delete();
        return response()->json(['message' => 'Удалено']);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'total' => Feedback::count(),
            'new' => Feedback::where('status', 'new')->count(),
            'answered' => Feedback::where('status', 'answered')->count(),
        ]);
    }
}

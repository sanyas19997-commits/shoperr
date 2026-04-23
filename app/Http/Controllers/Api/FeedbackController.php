<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FeedbackResource;
use App\Models\Feedback;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['nullable', 'string', 'max:32'],
            'subject' => ['required', 'string', 'max:191'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $data['user_id'] = $request->user()?->id;
        $data['status'] = 'new';

        $feedback = Feedback::create($data);

        return response()->json([
            'message' => 'Спасибо, мы получили ваше сообщение и свяжемся с вами в ближайшее время.',
            'data' => new FeedbackResource($feedback),
        ], 201);
    }
}

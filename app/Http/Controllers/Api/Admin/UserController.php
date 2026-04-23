<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%$q%")->orWhere('email', 'like', "%$q%");
            });
        }
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }
        return UserResource::collection($query->latest()->paginate(20));
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:32'],
            'role' => ['sometimes', Rule::in(['admin', 'user'])],
        ]);
        if (array_key_exists('role', $data) && $data['role'] !== 'admin' && $user->isAdmin()) {
            $remainingAdmins = User::where('role', 'admin')->where('id', '!=', $user->id)->count();
            if ($remainingAdmins === 0) {
                return response()->json([
                    'message' => 'Нельзя убрать роль у последнего администратора',
                ], 422);
            }
        }
        $user->update($data);
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return response()->json(['message' => 'Нельзя удалить администратора'], 422);
        }
        $user->delete();
        return response()->json(['message' => 'Удалено']);
    }
}

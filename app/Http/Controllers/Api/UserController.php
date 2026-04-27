<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $q = User::query()->withCount('orders');

        if ($s = $request->string('q')->toString()) {
            $q->where(function ($w) use ($s) {
                $w->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('phone', 'like', "%$s%");
            });
        }
        if ($role = $request->input('role')) {
            $q->where('role', $role);
        }

        return $q->latest()->paginate($request->integer('per_page', 20));
    }

    public function show(User $user)
    {
        $user->load(['orders' => fn ($q) => $q->latest()->take(20)]);
        $user->loadCount('orders');
        return response()->json(['data' => $user]);
    }

    public function store(Request $request)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Создание сотрудников доступно только администратору.'], 403);
        }
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_MANAGER, User::ROLE_CUSTOMER])],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $data['is_admin'] = $data['role'] === User::ROLE_ADMIN;
        $user = User::create($data);
        ActionLog::log('user.create', $user, ['role' => $user->role]);
        return response()->json(['data' => $user], 201);
    }

    public function update(Request $request, User $user)
    {
        $isAdminEditingOther = $request->user()->isAdmin() && $request->user()->id !== $user->id;
        $rules = [
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($user->id)],
        ];
        if ($isAdminEditingOther) {
            $rules['role'] = ['nullable', Rule::in([User::ROLE_ADMIN, User::ROLE_MANAGER, User::ROLE_CUSTOMER])];
            $rules['password'] = ['nullable', 'string', 'min:8'];
        }
        $data = $request->validate($rules);
        if (isset($data['role'])) {
            $data['is_admin'] = $data['role'] === User::ROLE_ADMIN;
        }
        $user->update($data);
        ActionLog::log('user.update', $user, $data);
        return response()->json(['data' => $user->fresh()]);
    }

    public function destroy(Request $request, User $user)
    {
        if (! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Удаление доступно только администратору.'], 403);
        }
        if ($user->id === $request->user()->id) {
            return response()->json(['message' => 'Нельзя удалить самого себя.'], 422);
        }
        ActionLog::log('user.delete', $user);
        $user->delete();
        return response()->json(['message' => 'Удалено.']);
    }
}

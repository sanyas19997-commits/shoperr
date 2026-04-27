<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Неверный email или пароль.'],
            ]);
        }

        if (! $user->isStaff()) {
            throw ValidationException::withMessages([
                'email' => ['У учётной записи нет доступа в админку.'],
            ]);
        }

        $token = $user->createToken('admin-spa', ['*'])->plainTextToken;
        ActionLog::log('login', $user);

        return response()->json([
            'token' => $token,
            'user' => $this->userPayload($user),
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user && $user->currentAccessToken()) {
            ActionLog::log('logout', $user);
            $user->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Выход выполнен.']);
    }

    public function me(Request $request)
    {
        return response()->json(['user' => $this->userPayload($request->user())]);
    }

    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();
        if (! Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Текущий пароль неверный.'],
            ]);
        }

        $user->update(['password' => $data['new_password']]);
        ActionLog::log('change_password', $user);

        return response()->json(['message' => 'Пароль обновлён.']);
    }

    private function userPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'role_label' => User::ROLES[$user->role] ?? $user->role,
            'is_admin' => $user->isAdmin(),
            'is_manager' => $user->isManager(),
        ];
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::min(6)],
            'phone' => ['nullable', 'string', 'max:32'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => $data['password'],
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return response()->json([
            'user' => new UserResource($user),
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        if (!Auth::attempt(
            ['email' => $credentials['email'], 'password' => $credentials['password']],
            (bool) ($credentials['remember'] ?? false)
        )) {
            return response()->json(['message' => 'Неверный email или пароль'], 422);
        }

        $request->session()->regenerate();

        return response()->json([
            'user' => new UserResource($request->user()),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Вы вышли из аккаунта']);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['user' => null]);
        }
        return response()->json(['user' => new UserResource($user)]);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        // Simplified: generate a token and return it (in real app, email is sent)
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'Если email зарегистрирован — инструкции отправлены']);
        }

        $token = Str::random(40);
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['email' => $user->email, 'token' => Hash::make($token), 'created_at' => now()]
        );

        // For demo purposes we include the token in the response.
        return response()->json([
            'message' => 'Токен для сброса пароля создан',
            'reset_token' => $token,
        ]);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'confirmed', PasswordRule::min(6)],
        ]);

        $row = \DB::table('password_reset_tokens')->where('email', $data['email'])->first();
        if (!$row || !Hash::check($data['token'], $row->token)) {
            return response()->json(['message' => 'Неверный токен'], 422);
        }

        $user = User::where('email', $data['email'])->firstOrFail();
        $user->password = $data['password'];
        $user->save();

        \DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

        return response()->json(['message' => 'Пароль обновлен']);
    }
}

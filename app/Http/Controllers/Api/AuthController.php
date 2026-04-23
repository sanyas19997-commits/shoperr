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

        $token = null;
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = Str::random(40);
            \DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['email' => $user->email, 'token' => Hash::make($token), 'created_at' => now()]
            );
            // Dev convenience: surface the token through logs only outside production.
            // In production, wire up a Mailable that sends the reset link via email.
            if (app()->environment('local', 'testing')) {
                logger()->info('password.reset.token', ['email' => $user->email, 'token' => $token]);
            }
        }

        $payload = [
            'message' => 'Если email зарегистрирован — инструкции отправлены',
        ];
        // Only expose the token to the SPA in non-production environments so the
        // demo reset form still works; in production the client is told to check email.
        if ($token !== null && app()->environment('local', 'testing')) {
            $payload['reset_token'] = $token;
        }

        return response()->json($payload);
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
        $expireMinutes = (int) config('auth.passwords.users.expire', 60);
        if ($row->created_at && \Carbon\Carbon::parse($row->created_at)->addMinutes($expireMinutes)->isPast()) {
            \DB::table('password_reset_tokens')->where('email', $data['email'])->delete();
            return response()->json(['message' => 'Токен истёк'], 422);
        }

        $user = User::where('email', $data['email'])->firstOrFail();
        $user->password = $data['password'];
        $user->save();

        \DB::table('password_reset_tokens')->where('email', $data['email'])->delete();

        return response()->json(['message' => 'Пароль обновлен']);
    }
}

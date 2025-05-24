<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $fields): array
    {
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'role' => $fields['role'] ?? 'user',
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('ecommerce-token')->plainTextToken;

        return compact('user', 'token');
    }

    public function login(array $fields): array|null
    {
        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return null;
        }

        $token = $user->createToken('ecommerce-token')->plainTextToken;

        return compact('user', 'token');
    }

    public function logout($user)
    {
        $user->tokens()->delete();
    }
}

<?php

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;


class AuthService {

    public function register(array $validatedData){
        
        $validatedData['password'] = Hash::make($validatedData['password']);

        return User::create($validatedData);

    }

    public function login(): array{
        
        $user = Auth::user();
        
        $token = $user->createToken('user_token', ['*'], now()->addSeconds(12000))->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];

    }

    public function logout(User $user){

        $user->currentAccessToken()->delete();
        
    }
}
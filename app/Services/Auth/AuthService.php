<?php

namespace App\Services\Auth;

use App\DTO\Auth\AuthDTO;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;


class AuthService {

    public function register(AuthDTO $validatedData){

        $user = User::create([
            'firstName' => $validatedData->firstName,
            'lastName' => $validatedData->lastName,
            'email' => $validatedData->email,
            'password' => Hash::make($validatedData->password)
        ]);

        event(new Registered($user));

        return $user;
    
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

    public function verifyEmail(Request $request){
        $user =  User::findOrFail($request->route('id'));

        if($user->hasVerifiedEmail()){
           
            return false;
            
        }else{
            
            $user->markEmailAsVerified();
            return true;

        }
    }
}
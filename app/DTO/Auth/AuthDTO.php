<?php
namespace App\DTO\Auth;

use App\Http\Requests\Auth\Register;

class AuthDTO
{

    public function __construct(
            public string $firstName,
            public string $lastName,
            public string $email,
            public string $password,
            public string $role
        ) {}

    public static function fromApiRequest(Register $request) : self
    {
        return new self(
            $request->validated(['firstName']),
            $request->validated(['lastName']),
            $request->validated(['email']),
            $request->validated(['password']),
            $request->validated(['role'])
        );
    }
    
    
}
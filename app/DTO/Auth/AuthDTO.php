<?php
namespace App\DTO\Auth;

use Illuminate\Support\Facades\Hash;

class AuthDTO{

    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;


    public function store(array $data){

        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->email = $data['email'];
        $this->password = Hash::make($data['password']);

    }

    public function toArray(): array{
        return [
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
    
}
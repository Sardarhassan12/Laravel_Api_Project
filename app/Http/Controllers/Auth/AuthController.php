<?php

namespace App\Http\Controllers\Auth;

use App\DTO\Auth\AuthDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\Login;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use F9Web\ApiResponseHelpers;
use GuzzleHttp\Psr7\Message;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


//Auth Controller
class AuthController extends Controller
{
    use ApiResponseHelpers;
    //
    public function __construct(private readonly AuthService $auth_service) {
        
    }


    public function register(Register $request){


        $registerUser = $this->auth_service->register(AuthDTO::fromApiRequest($request));

        return $this->respondWithSuccess([
            'success' => true,
            'message' => 'Registered! Check your email for verification link.',
        ]);

    }



    public function login(Login $request){


        $credentials = $request->validated();

        if(!Auth::attempt($credentials)){
         
            return $this->respondUnAuthenticated('Unauthenticated Credentials');

        }

        $loginData = $this->auth_service->login();

        return $this->respondWithSuccess([
            'message' => 'Login successful',
            'success' => true,
            'user' => $loginData['user'],
            'token' => $loginData['token'],
        ]);
    }

    

    public function logout(Request $request){
        $this->auth_service->logout($request->user());

        return $this->respondWithSuccess([
            'message' => 'Logout',
            'success' => true,
        ]);
    }

    public function verifyEmail(Request $request){

        $user = $this->auth_service->verifyEmail($request);

        return $user ? $this->respondWithSuccess([
                'message' => 'Email Verified Successfully',
                'success' => true
            ]) : $this->respondWithSuccess([
                'message' => 'Email Already Exists',
                'success' => false
            ]);
       
    }
}







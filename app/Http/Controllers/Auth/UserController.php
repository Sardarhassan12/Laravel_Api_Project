<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register;
use App\Http\Requests\Auth\Login;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use F9Web\ApiResponseHelpers;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
//Auth Controller
class UserController extends Controller
{
    use ApiResponseHelpers;
    //
    public function __construct(private readonly AuthService $auth_service) {
        
    }
    public function register(Register $request){
        
        $registerUser = $this->auth_service->register($request->validated());

        return $this->respondWithSuccess([
            'success' => true,
            'message' => 'User registered successfully',
            'user' => $registerUser,
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

        return $this->respondOk('Logout');
    }

}








// class UserController extends Controller
// {
//     //
//     public function register(Register_Request $request){
        
//         // $validated = Validator::make($request->all(),[
//         //     'firstName' => 'required|string',
//         //     'lastName' => 'required|string',
//         //     'email' => 'required|email|unique:users,email',
//         //     'password' => 'required|string' //Min 6 char
//         // ]);

//         // if($validated->fails()){
//         //     return response()->json([
//         //         'message' => 'User Not Registered',
//         //         'errors' => $validated->errors()
//         //     ],402);
//         // }

//         $validatedData = $request->validated();

//         $validatedData['password'] = Hash::make($validatedData['password']);

//         $registerUser = User::create($validatedData);

//         return response()->json([
//             'message' => 'User Register',
//             'success' => true,
//             'user' => $registerUser,
//         ], 200);

//     }

//     public function login(Request $request){

//         $validation = Validator::make($request->all(),[
//             'email' => 'required|email',
//             'password' => 'required|string'
//         ]);
        
//         if($validation->fails()){
//             return response()->json([
//                 'message' => ' Validation Fails -- Enter correct email or password'
//             ]);
//         }

//         $credentials = $validation->validated();

//         if(Auth::attempt($credentials)){
//             $user = Auth::user();
//             //Simple Token Generation
//             // $token = $user->createToken('user_token')->plainTextToken;
//             $token = $user->createToken('user_token', ['*'], now()->addSeconds(20))->plainTextToken;
//             //Assigning ability
//             // $token = $user->createToken('user_token', ['add'])->plainTextToken;
//             return response()->json([
//                 'message' => 'Login Successful',
//                 'user' => $credentials,
//                 'token' => $token
//             ]);
//         }

//         return response()->json([
//             'message' => 'Login UnSuccessful',
//         ]);
//     }

//     // public function logout(){
//     //     $user = Auth::user();
//     //     $user->tokens()->delete();

//     //     return response()->json([
//     //         'message' => 'Logout'
//     //     ]);

//     // }
//     public function logout(Request $request){
//         $user = $request->user(); 
        
//         $user->tokens()->delete();

//         return response()->json([
//             'message' => 'Logout'
//         ]);
//     }

// }
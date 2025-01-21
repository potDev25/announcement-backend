<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index(Request $request){
        $user = $request->user();

        return response(compact(
            'user'
        ));
    }

    public function login(LoginRequest $request){
        $payload = $request->validated();

        if(!Auth::attempt($payload)){
            return response([
                'message_error' => 'Invalid Credentials'
            ], 422);
        }

       /** @var User $user **/
        $user = Auth::user();
        $user_token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'user_token'));
    }

    public function store(RegisterRequest $request){
        $payload = $request->validated();

        unset($payload['password_confirmation']);

        DB::transaction(function () use ($payload){
            User::create($payload);
        });
        
        return response(200);
    }

    public function logout(Request $request){
        $user = $request->user();
        /** @var User $user **/
        $user->currentAccessToken()->delete();

        return response(200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request){
        $input = $request->all();
        $user = User::create($input);
        return response()->json([
            'success'   => true,
            'message'   => 'User created',
            'data'      => $user
        ]);
    }

    public function login(LoginRequest $request){
        $input = $request->all();
        if (!Auth::attempt($input)) {
            return response()->json([
                'success'   => false,
                'message'   => 'Invalid credentials',
                'data'      => []
            ]);
        }

        return response()->json([
            'success'   => true,
            'token'     => Auth::user()->createToken('token')->plainTextToken
        ],200);
    }

}

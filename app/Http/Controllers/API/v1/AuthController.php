<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\CEO;
use App\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData  = $request->validate([
            'name'      => 'required|max:55',
            'email'     => 'email|required|unique:users',
            'password'  => 'required|confirmed'
        ]);

        $validatedData['password']  = bcrypt($request->password);

        $user   = User::create($validatedData);

        $accessToken = $user->createToken('This is secret key iv')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData  = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if(!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('This is secret key iv')->accessToken;

        return response([
            'message' => 'Login successfully',
            'user' => auth()->user(),
            'access_token' => $accessToken
        ], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();

        return response([
            'message'   => 'Logout Successfuly',
            'token' => $token
        ], 200);
    }
}

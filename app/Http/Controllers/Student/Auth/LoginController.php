<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function store (Request $request ) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);


        if($validator->fails()){
            return response([
                'error' => $validator->errors(),
            ], 200);
        }


        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response([
                'error' => [
                    'credentials' => 'Incorrect credentials please check email and password'
                ]
            ], 401);
        }


        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->plainTextToken;

        $user = Auth::user();

        return response([
            'message' => 'login Success',
            'token' => $token,
            'user' => $user,
            'token_type' => 'Bearer'
        ]);

    }
}

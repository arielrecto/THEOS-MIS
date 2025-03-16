<?php

namespace App\Http\Controllers\Student\Auth;

use App\Models\User;
use App\Enums\UserRoles;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
        ]);


        if($validator->fails()){
            return response([
                'error' => $validator->errors()
            ], 422);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);


        $studentRole = Role::where('name', UserRoles::STUDENT->value)->first();


        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->plainTextToken;


        $user->assignRole($studentRole);



        return response([
            'user' => $user,
            'token' => $token
        ]);
    }
}

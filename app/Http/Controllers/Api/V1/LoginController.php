<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Adldap\Laravel\Facades\Adldap;

use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        $this->validateLogin($request);
        $username = $request->username;
        $password = $request->password;
        //$request->only('username', 'password')
        if (Auth::attempt($request->only('username', 'password'))) {
            //dd($request->user());
            return response()->json([
                'token' => $request->user()->createToken($request->name)->plainTextToken,
                'message' => 'Success'
            ]);
        }
        $user = User::where('username', $request['username'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer'
        ]);
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    public function validateLogin(Request $request)
    {
        return $request->validate([
            //'email' => 'required|email',
            'username' => 'required',
            'password' => 'required',
            'name' => 'required'
        ]);
    }
}

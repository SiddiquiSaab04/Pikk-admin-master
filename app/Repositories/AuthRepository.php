<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthInterface
{
    public function getUserWithRole($request)
    {
        $credentials['email'] = $request['email'];
        $credentials['password'] = $request['password'];

        $auth = Auth::guard('api')->getProvider()->retrieveByCredentials($credentials);
        $auth->getAllPermissions();

        return [
            'user' => $auth,
            'credentials' => $credentials,
        ];
    }

    public function generateToken($auth)
    {
        return $auth->createToken($auth->id)->plainTextToken;
    }

    public function logout($request)
    {
        Auth::user()->tokens()->delete();
        return [
            "status" => 1,
            'message' => 'Successfully logged out'
        ];
    }
}

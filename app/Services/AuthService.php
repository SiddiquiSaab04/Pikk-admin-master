<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login($request)
    {
        $user = $this->authRepository->getUserWithRole($request);
        $role = $user['user']->roles->first();
        $type = isset($request['type']) ? $request['type'] : 'pos';
        if ($role->hasPermissionTo($type)) {
            if ($user['user'] && Hash::check($user['credentials']['password'], $user['user']->getAuthPassword())) {
                $token =  $this->authRepository->generateToken($user['user']);
                $response = [
                    'auth' => $user['user']->makeHidden('roles','permissions'),
                    'token' => $token
                ];
                return sendResponse(true, null, $response, 'Successfully logged in.', 200);
            } else {
                return sendError(true, null, 'The provided credentials are incorrect.', null, 401);
            }
        } else {
            return sendError(true, null, 'You are not allowed to log in.', null, 401);
        }
    }

    public function logout($request)
    {
        $response = $this->authRepository->logout($request);
        return sendResponse(true, null, $response, null, 200);
    }
}

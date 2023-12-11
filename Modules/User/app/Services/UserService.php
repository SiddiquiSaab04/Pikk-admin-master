<?php

namespace Modules\User\app\Services;

use Spatie\Permission\Models\Role;
use Modules\User\app\Repositories\UserRepository;
use Exception;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers()
    {
        return $this->userRepository->getAllusers();
    }

    public function createUser($request)
    {
        try {
            $user = $this->userRepository->createUser($request);
            $role = Role::where('name', $request['role'])->first();
            $user->assignRole($role);

            return [
                "status" => 1,
                "success_message" => "User created successfully"
            ];
        } catch (Exception $e) {
            return [
                "status" => 0,
                "error_message" => $e->getMessage()
            ];
        }
    }

    public function updateUser($request, $id)
    {
        try {
            $user = $this->userRepository->updateUser($id, $request);
            $role = Role::where('name', $request['role'])->first();
            $user->assignRole($role);

            return [
                "status" => 1,
                "success_message" => "User updated successfully"
            ];
        } catch (Exception $e) {
            return [
                "status" => 0,
                "error_message" => $e->getMessage()
            ];
        }
    }
}

<?php

namespace Modules\User\app\Services;

use Modules\User\app\Repositories\UserRepository;

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
}
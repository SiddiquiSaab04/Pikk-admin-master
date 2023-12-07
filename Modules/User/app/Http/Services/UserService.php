<?php

namespace User\app\Services;

use User\app\Interfaces\UserRepositoryInterface;

class UserService 
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers() 
    {
        return $this->userRepository->getAllusers();
    }
}
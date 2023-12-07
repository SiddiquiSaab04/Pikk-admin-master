<?php

namespace Modules\User\app\Interfaces;

interface UserRepositoryInterface
{
    public function getAllUsers();
    public function getUserbyId($id);
    public function deleteUser($id);
    public function searchUser($slug);
    public function createUser(array $data);
    public function updateUser(string $id, array $data);
    public function getUsersWith(string $relation);
}
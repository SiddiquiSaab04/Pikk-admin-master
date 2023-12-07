<?php

namespace User\app\Repositories;

use User\app\Interfaces\UserRepositoryInterface;
use User\app\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getAllUsers()
    {
        return User::get();
    }

    public function getUserbyId($id)
    {
        return User::find($id);
    }

    public function deleteUser($id)
    {
        return User::find($id)->delete();
    }

    public function searchUser($slug)
    {
        return User::where(function($query) use ($slug) {
            $query->where('name', "%".$slug."%");
            $query->orWhere('email', "%".$slug."%");
        });

    }

    public function createUser(array $data)
    {
        return User::create($data);
    }

    public function updateUser(string $id, array $data)
    {
        return User::where('_id', $id)->update($data);
    }

    public function getUsersWith(string $relation)
    {
        return User::with($relation)->get();
    }

    public function loadUserWith(User $user, string $relation)
    {
        return $user->load($relation);
    }
}
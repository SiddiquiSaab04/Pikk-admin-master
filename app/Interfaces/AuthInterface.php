<?php

namespace App\Interfaces;

interface AuthInterface
{
    public function getUserWithRole(array $request);
    public function generateToken(array $request);
    public function logout(string $request);
}

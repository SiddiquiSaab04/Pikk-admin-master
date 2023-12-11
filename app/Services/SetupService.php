<?php

namespace App\Services;

use App\Repositories\SetupRepository;

class SetupService
{
    private $setupRepository;

    public function __construct(SetupRepository $setupRepository)
    {
        $this->setupRepository = $setupRepository;
    }
}

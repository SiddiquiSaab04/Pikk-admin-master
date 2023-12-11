<?php

namespace App\Services;

use App\Traits\Helper;

class CoreService
{
    public function installed()
    {
        return Helper::installed();
    }
}

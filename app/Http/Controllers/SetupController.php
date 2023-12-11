<?php

namespace App\Http\Controllers;

use App\Services\SetupService;
use Illuminate\Http\Request;

class SetupController extends Controller
{
    private $setupService;

    public function __construct(SetupService $setupService)
    {
        $this->setupService = $setupService;
    }

    public function welcome()
    {
        return view('setup.do-setup');
    }
}

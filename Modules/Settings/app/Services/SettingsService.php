<?php

namespace Modules\Settings\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;

class SettingsService
{
    use Crud;

    protected $crudRepository;
    protected $model;

    public function __construct(CrudRepository $crudRepository)
    {
        $this->model = "\\Modules\\Settings\\app\\Models\\Setting";
        $this->crudRepository = $crudRepository;
    }
}

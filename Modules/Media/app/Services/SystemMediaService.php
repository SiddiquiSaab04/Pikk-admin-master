<?php

namespace Modules\Media\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Modules\Media\app\Repositories\MediaRepository;

class SystemMediaService
{
  use Crud;

  protected $crudRepository;
  protected $mediaRepository;
  protected $model;

  public function __construct(CrudRepository $crudRepository, MediaRepository $mediaRepository)
  {
    $this->model = "\\Modules\\Media\\app\\Models\\Media";
    $this->crudRepository = $crudRepository;
    $this->mediaRepository = $mediaRepository;
  }

  // public function create($created)
  // {
  //   foreach (json_decode($created['url'], true) as $create) {
  //     $this->crudRepository->create($this->model, [
  //       'name' => $created['name'],
  //       'cloud' => $created['cloud'],
  //       'url' => $create,
  //     ]);
  //   }
  // }
}

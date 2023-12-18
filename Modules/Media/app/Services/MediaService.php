<?php

namespace Modules\Media\app\Services;

use App\Repositories\CrudRepository;
use App\Traits\Crud;
use Modules\Media\app\Repositories\MediaRepository;

class MediaService
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
    public function create($created)
    {
        foreach (json_decode($created['url'], true) as $create) {
            $this->crudRepository->create($this->model, [
                'name' => $created['name'],
                'cloud' => $created['cloud'],
                'url' => $create,
            ]);
        }
    }

    public function createLocalMedia($request)
    {
        return $this->mediaRepository->createLocalMedia($request);
    }

    public function updateLocalMedia($media, $request)
    {
        return $this->mediaRepository->updateLocalMedia($media, $request);
    }

    public function deleteLocalMedia($url)
    {
        return $this->mediaRepository->deleteLocalMedia($url);
    }

    public function createCloudMedia()
    {
        return $this->mediaRepository->createCloudMedia();
    }
    public function updateCloudMedia()
    {
        return $this->mediaRepository->updateCloudMedia();
    }
    public function deleteCloudMedia()
    {
        return $this->mediaRepository->deleteCloudMedia();
    }
}

<?php

namespace Modules\Media\app\Interfaces;

use Modules\Media\app\Models\Media;

interface MediaRepositoryInterface
{
    public function createLocalMedia(array $request);
    public function updateLocalMedia(Media $media, array $request);
    public function deleteLocalMedia(string $url);
    public function createCloudMedia();
    public function updateCloudMedia();
    public function deleteCloudMedia();
}

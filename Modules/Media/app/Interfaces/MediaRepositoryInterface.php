<?php

namespace Modules\Media\app\Interfaces;

interface MediaRepositoryInterface
{
    public function createLocalMedia(array $request);
    public function updateLocalMedia(array $media, array $request);
    public function deleteLocalMedia(array $urls);
    public function createCloudMedia();
    public function updateCloudMedia();
    public function deleteCloudMedia();
}

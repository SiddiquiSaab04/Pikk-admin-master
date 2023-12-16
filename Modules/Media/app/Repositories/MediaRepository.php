<?php

namespace Modules\Media\app\Repositories;

use Modules\Media\app\Interfaces\MediaRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class MediaRepository implements MediaRepositoryInterface
{
    public function createLocalMedia($request)
    {
        $images = $request['images'];
        $storageFolderPath = storage_path('app/public/images');
        if (!file_exists($storageFolderPath)) {
            mkdir($storageFolderPath, 0777, true);
        }

        $storageLinkPath = public_path('storage');
        if (!file_exists($storageLinkPath)) {
            Artisan::call('storage:link');
        }

        $imagePaths = [];
        foreach ($images as $image) {
            $imageName = Str::uuid()->toString() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);

            $imagePaths[] = asset('storage/images/' . $imageName);
        }

        $request['cloud'] = 0;
        $request['url'] = json_encode($imagePaths);

        return $request;
    }

    public function updateLocalMedia($media, $request)
    {
        $oldImages = $media->url;
        $oldImagesPath = $request->input('oldImages');

        if (is_null($oldImagesPath)) {
            $this->deleteLocalMedia($oldImages);
            $created = $this->createLocalMedia($request);
            $request['url'] = json_decode($created->url)[0];
        }

        $request['cloud'] = false;
        return $request;
    }

    public function deleteLocalMedia($url)
    {
        $folderPath = 'public/images';

        $filename = pathinfo($url, PATHINFO_BASENAME);
        $filePath = $folderPath . '/' . $filename;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }

    public function createCloudMedia()
    {
    }

    public function updateCloudMedia()
    {
    }

    public function deleteCloudMedia()
    {
    }
}

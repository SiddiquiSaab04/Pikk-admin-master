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

        $request['cloud'] = false;
        $request['url'] = json_encode($imagePaths);

        return $request;
    }

    public function updateLocalMedia($media, $request)
    {
        $oldImages = json_decode($media->url);
        $newImages = $request->images;
        $oldImagesPath = $request->input('oldImages');

        if (!is_null($oldImagesPath) && !is_null($newImages[0]) && count($oldImagesPath) === count($oldImages)) {
            $created = $this->createLocalMedia($request);
            $mergeUrls = array_merge($oldImages, json_decode($created->url));
            $request['url'] = $mergeUrls;
        }

        if (!is_null($oldImagesPath) && count($oldImagesPath) !== count($oldImages)) {

            $removedImages = array_diff($oldImages, $oldImagesPath);
            $this->deleteLocalMedia(json_encode($removedImages));

            if (!is_null($newImages[0])) {
                $created = $this->createLocalMedia($request);
                $presentImages = array_intersect($oldImages, $oldImagesPath);
                $mergeUrls = array_merge($presentImages, json_decode($created->url));
                $request['url'] = $mergeUrls;
            } else {
                $request['url'] = array_intersect($oldImages, $oldImagesPath);
            }
        }

        if (is_null($oldImagesPath)) {
            $this->deleteLocalMedia(json_encode($oldImages));
            
            $created = $this->createLocalMedia($request);
            $request['url'] = json_decode($created->url);
        }

        $request['cloud'] = false;
        return $request;
    }

    public function deleteLocalMedia($urls)
    {
        $folderPath = 'public/images';

        foreach (json_decode($urls) as $url) {
            $filename = pathinfo($url, PATHINFO_BASENAME);
            $filePath = $folderPath . '/' . $filename;

            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
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

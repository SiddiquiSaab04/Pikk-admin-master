<?php

namespace Modules\Media\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Media\app\Http\Requests\MediaRequest;
use Modules\Media\app\Services\mediaService;

class MediaController extends Controller
{
    private $mediaService;

    public function __construct(mediaService $mediaService)
    {
        $this->mediaService = $mediaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medias = $this->mediaService->getAll();

        if (request()->wantsjson()) {
            return sendResponse('media::index', [
                "medias" => $medias,
                "title" => "Media List",
                "description" => "show all medias"
            ]);
        } else {
            return sendResponse(false, 'media::index', [
                "medias" => $medias,
                "title" => "Media List",
                "description" => "show all medias"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return sendResponse(false, 'media::create', [
            "title" => "Create Media",
            "description" => "create a new media"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MediaRequest $request): RedirectResponse
    {
        $isCloud = boolval($request->input('cloud'));
        if (!$isCloud) {
            $created = $this->mediaService->createLocalMedia($request->all());
            $this->mediaService->create($created);
        } else {
            dd('AWS credentials required');
            $this->mediaService->createCloudMedia();
        }

        return redirect()->route('media.index')->withToastSuccess("Media created successfully.");
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $media = $this->mediaService->search($id);
        if (request()->wantsjson()) {
            return sendResponse('media::index', [
                "media" => $media,
                "title" => "Media List",
                "description" => "show all medias"
            ]);
        } else {
            return sendResponse(false, 'media::index', [
                "media" => $media,
                "title" => "Media List",
                "description" => "show all medias"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $media = $this->mediaService->getById($id);
        return view('media::edit', [
            "media" => $media,
            "title" => "Edit Media",
            "description" => "edit a media"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MediaRequest $request, $id): RedirectResponse
    {
        $media = $this->mediaService->getById($id);
        !$media->cloud ? $this->mediaService->updateLocalMedia($media, $request) : $this->mediaService->updateCloudMedia();
        $this->mediaService->update($request->all(), $id);
        return redirect()->route('media.index')->withToastSuccess("Media updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $media = $this->mediaService->getById($id);
        !$media->cloud ? $this->mediaService->deleteLocalMedia($media->url) : $this->mediaService->deleteCloudMedia();
        $this->mediaService->delete($id);
        return redirect()->route('media.index')->withToastSuccess("Media deleted successfully.");
    }
}

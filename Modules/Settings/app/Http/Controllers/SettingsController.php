<?php

namespace Modules\Settings\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\app\Services\SettingsService;

class SettingsController extends Controller
{
    private $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = $this->settingsService->getAll();

        if (request()->wantsjson()) {
            return sendResponse('settings::index', [
                "settings" => $settings,
                "title" => "Settings List",
                "description" => "show all settings"
            ]);
        } else {
            return sendResponse(false, 'settings::index', [
                "settings" => $settings,
                "title" => "Settings List",
                "description" => "show all settings"
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $settings = $this->settingsService->getTransformedArray();

        return sendResponse(false, 'settings::create', [
            "title" => "Create Settings",
            "description" => "create a new settings",
            'settings' => $settings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $settings = $this->settingsService->createSettings($request->all());
        if ($settings['status']) {
            return redirect()->back()->withToastSuccess($settings['message']);
        } else {
            return redirect()->back()->withToastError($settings['message']);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $setting = $this->settingsService->search($id);

        if (request()->wantsjson()) {
            return sendResponse('settings::index', [
                "setting" => $setting,
                "title" => "Setting List",
                "description" => "show setting"
            ]);
        } else {
            return sendResponse(false, 'settings::index', [
                "setting" => $setting,
                "title" => "Setting List",
                "description" => "show asetting"
            ]);
        }

        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $setting = $this->settingsService->getById($id);

        return view('settings::edit', [
            "setting" => $setting,
            "title" => "Edit Media",
            "description" => "edit a media"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function getPosConfiguration()
    {
        $setting = $this->settingsService->getPosConfiguration();
        if (request()->wantsJson()) {
            return sendResponse(true, null, json_decode($setting->value), null, 200);
        } else {
            //
        }
    }

    public function storePosConfiguration(Request $request)
    {
        $settings = $this->settingsService->storePosConfiguration($request->all());
        if (request()->wantsJson()) {
            return sendResponse(true, null, $settings, null, 200);
        } else {
            //
        }
    }
}

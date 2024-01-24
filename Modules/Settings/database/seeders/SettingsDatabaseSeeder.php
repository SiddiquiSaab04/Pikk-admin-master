<?php

namespace Modules\Settings\database\seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Modules\Settings\app\Models\Setting;
use Illuminate\Support\Facades\Artisan;

class SettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $environment =  App::environment();
        if ($environment == "local") {
            $baseUrl = url()->current() . ":8000/storage/media/system/";
        } else {
            $baseUrl = url()->current() . "/storage/media/system/";
        }

        $storageFolderPath = storage_path('app/public/media/system');
        if (!file_exists($storageFolderPath)) {
            mkdir($storageFolderPath, 0777, true);
        }

        $storageLinkPath = public_path('storage');
        if (!file_exists($storageLinkPath)) {
            Artisan::call('storage:link');
        }

        $settings = [
            [
                "key" => "web_lg",
                "value" => [
                    "platform" => "web",
                    "value" => $baseUrl . "web_lg.png"
                ]
            ],
            [
                "key" => "web_md",
                "value" => [
                    "platform" => "web",
                    "value" => $baseUrl . "web_md.png"
                ]
            ],
            [
                "key" => "web_sm",
                "value" => [
                    "platform" => "web",
                    "value" => $baseUrl . "web_sm.png"
                ]
            ],
            [
                "key" => "pos_lg",
                "value" => [
                    "platform" => "pos",
                    "value" => $baseUrl . "pos_lg.png"
                ]
            ],
            [
                "key" => "pos_md",
                "value" => [
                    "platform" => "pos",
                    "value" => $baseUrl . "pos_md.png"
                ]
            ],
            [
                "key" => "pos_sm",
                "value" => [
                    "platform" => "pos",
                    "value" => $baseUrl . "pos_sm.png"
                ]
            ],
            [
                "key" => "kds_lg",
                "value" => [
                    "platform" => "kds",
                    "value" => $baseUrl . "kds_lg.png"
                ]
            ],
            [
                "key" => "kds_md",
                "value" => [
                    "platform" => "kds",
                    "value" => $baseUrl . "kds_md.png"
                ]
            ],
            [
                "key" => "kds_sm",
                "value" => [
                    "platform" => "kds",
                    "value" => $baseUrl . "kds_sm.png"
                ]
            ],
        ];

        try {
            collect($settings)->each(function ($setting) {
                $setting['value'] = json_encode($setting['value']);
                Setting::updateOrCreate([
                    'key' => $setting['key']
                ], $setting);
            });
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}

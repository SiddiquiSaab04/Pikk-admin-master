<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Media\app\Models\Media;

class CustomConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $config = [];

        // $bg_website = Media::where('name', 'bg_website')->first();
        // $bg_tablet = Media::where('name', 'bg_tablet')->first();
        // $bg_mobile = Media::where('name', 'bg_mobile')->first();

        // $config['bg_website'] = $bg_website ? $bg_website->url : 'default_bg_website_url';
        // $config['bg_tablet'] = $bg_tablet ? $bg_tablet->url : 'default_bg_tablet_url';
        // $config['bg_mobile'] = $bg_mobile ? $bg_mobile->url : 'default_bg_mobile_url';

        // $this->app->instance('custom', $config);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class GlobalVariablesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        if (!file_exists(public_path('install.php'))) {
            try {
                $site = Cache::rememberForever('site', function () {
                    return Setting::all()->keyBy('key');
                });

                app()->instance('site', $site);
                View::share('site', $site);
            } catch (\Exception $e) {
                // DB not ready yet (e.g. during migrations)
            }
        }
    }
}

<?php

namespace App\Providers;

use Exception;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();

        try {
            if (file_get_contents('../VERSION')) {
                $version = File::get('../VERSION');
                config(['app.version' => $version]);
            }
        } catch (Exception $exception) {
            // Sometimes an exception is thrown even though the file exists,
            // So instead of logging that exception, we let it disappear.
        }
    }
}

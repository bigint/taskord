<?php

namespace App\Providers;

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

        if (file_exists('../VERSION')) {
            $version = File::get('../VERSION');
            config(['app.version' => $version]);
        } else {
            $version = '0.0.0';
            config(['app.version' => $version]);
        }
    }
}

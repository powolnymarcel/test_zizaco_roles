<?php

namespace App\Providers;

use App\Tag;
use Illuminate\Support\ServiceProvider;

class TagServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('partials.sidebar', function ($view) {
            return $view->with('tags', Tag::get());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

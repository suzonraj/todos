<?php

namespace App\Providers;

use App\Models\Todo;
use App\Observers\TodoObserver;
use Illuminate\Support\ServiceProvider;

/**
 * Class ObserverServiceProvider.
 */
class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function boot()
    {
        Todo::observe(TodoObserver::class);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}

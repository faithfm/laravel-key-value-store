<?php

namespace FaithFM\KeyValueStore;

use Illuminate\Support\ServiceProvider;

class KeyValueStoreServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Load migration
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        // Publish migration
        $this->publishes([
            __DIR__.'/migrations/' => database_path('/migrations/'),
        ], 'migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        // bind key value store class
        $this->app->bind(
            'FaithFM\KeyValueStore\KeyValueStoreClass'
        );
    }
}

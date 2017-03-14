<?php

namespace SquareBoat\Baker;

use Illuminate\Support\ServiceProvider;

class BakerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                \SquareBoat\Baker\Commands\RepositoryContractMakeCommand::class,
                \SquareBoat\Baker\Commands\RepositoryMakeCommand::class,
                \SquareBoat\Baker\Commands\ModelMakeCommand::class,
                \SquareBoat\Baker\Commands\ControllerMakeCommand::class,
                \SquareBoat\Baker\Commands\ServiceMakeCommand::class,
            ]);
        }
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

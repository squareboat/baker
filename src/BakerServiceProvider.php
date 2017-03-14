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
                \SquareBoat\Baker\Commands\RepositoryContractBakeCommand::class,
                \SquareBoat\Baker\Commands\RepositoryBakeCommand::class,
                \SquareBoat\Baker\Commands\ModelBakeCommand::class,
                \SquareBoat\Baker\Commands\ControllerBakeCommand::class,
                \SquareBoat\Baker\Commands\ServiceBakeCommand::class,
                \SquareBoat\Baker\Commands\ValidatorBakeCommand::class,
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

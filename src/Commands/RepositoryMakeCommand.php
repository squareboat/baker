<?php

namespace SquareBoat\Baker\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bake:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $stub = $this->replaceModel($stub, $this->option('model'));

        return $this->replaceContract($stub, class_basename($name));
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @param  string  $model
     * @return string
     */
    protected function replaceModel($stub, $model)
    {
        $model = str_replace('/', '\\', $model);

        if (Str::startsWith($model, '\\')) {
            $stub = str_replace('NamespacedDummyModel', trim($model, '\\'), $stub);
        } else {
            $stub = str_replace('NamespacedDummyModel', $this->laravel->getNamespace().$model, $stub);
        }

        $model = class_basename(trim($model, '\\'));

        return str_replace('DummyModel', $model, $stub);
    }

    /**
     * Replace the contract for the given stub.
     *
     * @param  string  $stub
     * @param  string  $contract
     * @return string
     */
    protected function replaceContract($stub, $contract)
    {
        $contract = $this->rootNamespace().'Repositories\Contracts\\'.$contract;

        $stub = str_replace('NamespacedDummyContract', $contract, $stub);

        $contract = class_basename($contract).'Contract';

        return str_replace('DummyContract', $contract, $stub);;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/repository.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories\\'.Str::studly($this->option('type'));
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'The model that is associated with the repository.'],
            ['type', 't', InputOption::VALUE_OPTIONAL, 'The type of repository being created.', 'database']
        ];
    }
}

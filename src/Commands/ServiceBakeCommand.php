<?php

namespace SquareBoat\Baker\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ServiceBakeCommand extends BakerCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bake:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        return $this->replaceRepository($stub, $this->option('repository'));
    }

    /**
     * Replace the repository for the given stub.
     *
     * @param  string  $stub
     * @param  string  $repository
     * @return string
     */
    protected function replaceRepository($stub, $repository)
    {
        $repository = str_replace('/', '\\', $repository);

        if (Str::startsWith($repository, '\\')) {
            $stub = str_replace('NamespacedDummyRepository', trim($repository, '\\'), $stub);
        } else {
            $stub = str_replace('NamespacedDummyRepository', $this->laravel->getNamespace().'Repository\Contracts\\'.$repository, $stub);
        }

        $repository = class_basename(trim($repository, '\\'));

        $stub = str_replace('DummyRepository', $repository, $stub);

        return str_replace('dummyRepository', Str::camel($repository), $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('repository')) {
            return __DIR__.'/stubs/service.stub';
        }

        return __DIR__.'/stubs/service.plain.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Services';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['repository', 'r', InputOption::VALUE_REQUIRED, 'The repository that the service serves.'],
        ];
    }
}

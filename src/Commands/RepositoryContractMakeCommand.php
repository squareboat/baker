<?php

namespace SquareBoat\Baker\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class RepositoryContractMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bake:repository-contract';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository contract class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository Contract';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() === false) {
            return;
        }

        if ($this->option('repository')) {
            $this->createRepository();
        }
    }

    /**
     * Create a repository for the contract.
     *
     * @return void
     */
    protected function createRepository()
    {
        $this->call('bake:repository', [
            'name' => $this->argument('name'),
            '--model' => $this->option('model'),
            '--type' => $this->option('type'),
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/repository-contract.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories\Contracts';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository contract.'],
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
            ['repository', 'r', InputOption::VALUE_NONE, 'Create a new repository file for the contract.'],

            ['model', 'm', InputOption::VALUE_REQUIRED, 'The model that is associated with the repository.', 'Model'],

            ['type', 't', InputOption::VALUE_OPTIONAL, 'The type of repository being created.', 'database'],
        ];
    }
}

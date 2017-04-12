<?php

namespace SquareBoat\Baker\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class BakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'bake';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bake the new cake in the bakery.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->info('Baking...');

        $this->bakeTheCake();

        $this->info($this->cake());

        $this->info('Your cake is baked and ready to be served.');
    }

    /**
     * Bakes the cake.
     *
     * @return void
     */
    private function bakeTheCake() {
        // $this->bakeMigration();

        $this->bakeModel();

        $this->option('no-repo') ?: $this->bakeRepository();

        $this->option('no-validator') ?: $this->bakeValidator();

        $this->option('no-service') ?: $this->bakeService();

        $this->option('no-controller') ?: $this->bakeController();
    }

    /**
     * Bake migration file for the model.
     *
     * @return void
     */
    protected function bakeMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Bake model file.
     *
     * @return void
     */
    protected function bakeModel()
    {
        $this->call('bake:model', [
            'name' => $this->argument('name')
        ]);
    }

    /**
     * Bake the repository and contract for the model.
     *
     * @return void
     */
    protected function bakeRepository()
    {
        $modelName = $this->argument('name');

        $repoName = $this->option('repo') ?: $modelName;

        $repository = Str::studly(class_basename($repoName));

        $model = Str::studly(class_basename($modelName));

        $this->call('bake:repository-contract', [
            'name' => "{$repository}Repository",
            '--repository' => true,
            '--model' => $model,
        ]);
    }

    /**
     * Bake the validator for the model.
     *
     * @return void
     */
    protected function bakeValidator()
    {
        $validatorName = $this->option('validator') ?: $this->argument('name');

        $validator = Str::studly(class_basename($validatorName));

        $this->call('bake:validator', [
            'name' => "{$validator}Validator"
        ]);
    }

    /**
     * Bake the service.
     *
     * @return void
     */
    protected function bakeService()
    {
        $serviceName = $this->option('service') ?: $this->argument('name');

        $repoName = $this->option('repo') ?: $this->argument('name');

        $service = Str::studly(class_basename($serviceName));

        $repo = Str::studly(class_basename($repoName));

        $this->call('bake:service', [
            'name' => "{$service}Service",
            '--repository' => "{$repo}Repository",
        ]);
    }

    /**
     * Bake the controller for the model.
     *
     * @return void
     */
    protected function bakeController()
    {
        $controllerName = $this->option('controller') ?: $this->argument('name');

        $controller = Str::studly(class_basename($controllerName));

        $this->call('bake:controller', [
            'name' => "{$controller}Controller",
        ]);
    }

    /**
     * Get the baked cake.
     *
     * @return string
     */
    private function cake()
    {
        return <<<EOF
             ,,,,,
            _|||||_
           {~*~*~*~}
         __{*~*~*~*}__
        `-------------`
EOF;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the cake'],
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
            ['service', 'serv', InputOption::VALUE_REQUIRED, 'Bake service with this name'],
            ['repo', 'rep', InputOption::VALUE_REQUIRED, 'Bake repository with this name'],
            ['validator', 'val', InputOption::VALUE_REQUIRED, 'Bake validator with this name'],
            ['controller', 'con', InputOption::VALUE_REQUIRED, 'Bake controller with this name'],

            ['no-service', 'no-serv', InputOption::VALUE_NONE, 'Don\'t bake service'],
            ['no-repo', 'no-rep', InputOption::VALUE_NONE, 'Don\'t bake repository'],
            ['no-validator', 'no-val', InputOption::VALUE_NONE, 'Don\'t bake validator'],
            ['no-controller', 'no-con', InputOption::VALUE_NONE, 'Don\'t bake controller'],
        ];
    }
}

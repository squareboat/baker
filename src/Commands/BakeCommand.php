<?php

namespace SquareBoat\Baker\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
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

        $this->bakeRepository();

        $this->bakeValidator();

        $this->bakeService();

        $this->bakeController();
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
        $repository = Str::studly(class_basename($this->argument('name')));

        $this->call('bake:repository-contract', [
            'name' => "{$repository}Repository",
            '--repository' => true,
            '--model' => $repository,
        ]);
    }

    /**
     * Bake the validator for the model.
     *
     * @return void
     */
    protected function bakeValidator()
    {
        $validator = Str::studly(class_basename($this->argument('name')));

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
        $service = Str::studly(class_basename($this->argument('name')));

        $this->call('bake:service', [
            'name' => "{$service}Service",
            '--repository' => "{$service}Repository",
        ]);
    }

    /**
     * Bake the controller for the model.
     *
     * @return void
     */
    protected function bakeController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

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
}

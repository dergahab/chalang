<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatatableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:datatable {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Datatable';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $defaultNamespace = 'App\Datatable';

        // Extract the namespace and name from the given argument
        $namespace = $defaultNamespace;
        if (str_contains($name, '/')) {
            $parts = explode('/', $name);
            $name = array_pop($parts);
            $namespace .= '\\'.implode('\\', $parts);
        }

        $convertNamespace = str_replace('\\', '/', $namespace);
        $path = "${convertNamespace}/${name}.php";

        if (file_exists($path)) {
            $this->error('Datatable already exists');

            return;
        }

        // Check if the directory for the file exists, and create it if it doesn't
        if (! file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $stub = file_get_contents(__DIR__.'/Stubs/datatable.stub');

        $stub = str_replace($defaultNamespace, $namespace, $stub);
        $stub = str_replace('DummyClass', $name, $stub);
        $modelName = rtrim($name, 'Datatable');
        $stub = str_replace('Test::class', $modelName.'::class', $stub);

        file_put_contents($path, $stub);

        $this->info('Datatable has been created succesfully');
    }
}

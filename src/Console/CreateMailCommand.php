<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;

class CreateMailCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:correo {name} {model} {var-singular} {subject}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear correo';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Mail';

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace('{{class-name}}', $this->argument('name'), $stub);
    }

    /**
     * Remplaza las variables.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceVaribales(&$stub)
    {
        $stub = str_replace('{{model}}', $this->argument('model'), $stub);
        $stub = str_replace('{{var-singular}}', $this->argument('var-singular'), $stub);
        $stub = str_replace('{{subject}}', $this->argument('subject'), $stub);
        $stub = str_replace('{{view-name}}', lcfirst($this->argument('name')), $stub);
        
        return $this;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  app_path() . '/stubs/mail.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Mail';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        //crear vista
        Artisan::call('make:view-mail', [
            'name' => $this->argument('name'), 
            'subject' => $this->argument('subject'),
            'var-singular' => $this->argument('var-singular')
        ]);

        return $this->replaceVaribales($stub)
                ->replaceNamespace($stub, $name)
                ->replaceClass($stub, $name);
    }
}

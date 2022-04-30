<?php

namespace LuisJ\BaseModule\Console;

use Illuminate\Console\GeneratorCommand;

class CreateMailViewCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view-mail {name} {subject} {var-singular}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear vista del mail';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'View';

    /**
     * Remplaza las variables.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceVaribales(&$stub)
    {
        $stub = str_replace('{{subject}}', $this->argument('subject'), $stub);
        $stub = str_replace('{{var-singular}}', $this->argument('var-singular'), $stub);
        
        return $this;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  '../../stubs/mail-html.blade.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return 'resources/views/emails'.'/'.lcfirst($this->argument('name')).'.blade.php';
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

        return $this->replaceVaribales($stub)
                ->replaceNamespace($stub, $name)
                ->replaceClass($stub, $name);
    }
}

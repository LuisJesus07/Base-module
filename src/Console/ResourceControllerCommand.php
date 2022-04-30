<?php

namespace LuisJ\BaseModule\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;

class ResourceControllerCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:resourse-module {name} {model} {modulo} {ref} {var-plural} {var-singular} {log-plural} {log-singular} {route} {folder-view} {is_user} {has_cover} {db_table} {create_factory} {has_belong_to_many} {model_to_attach} {relation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea un controlador base con logs';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Controller';

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

        return str_replace('ResourseController', $this->argument('name'), $stub);
    }

    /**
     * Remplaza las variables.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceVaribales(&$stub)
    {

        if($this->argument('has_belong_to_many') == "true"){
            $stub = str_replace('{{belongs_to_many_functions}}', $this->belongs_to_many_functions(), $stub);
            $stub = str_replace('{{model_to_attach}}', $this->argument('model_to_attach'), $stub);
            $stub = str_replace('{{relation}}', $this->argument('relation'), $stub);
        }else{
            $stub = str_replace('{{belongs_to_many_functions}}', "\n", $stub);
        }

        $stub = str_replace('{{model}}', $this->argument('model'), $stub);
        $stub = str_replace('{{modulo}}', $this->argument('modulo'), $stub);
        $stub = str_replace('{{ref}}', $this->argument('ref'), $stub);
        $stub = str_replace('{{var-plural}}', $this->argument('var-plural'), $stub);
        $stub = str_replace('{{var-singular}}', $this->argument('var-singular'), $stub);
        $stub = str_replace('{{log-plural}}', $this->argument('log-plural'), $stub);
        $stub = str_replace('{{log-singular}}', $this->argument('log-singular'), $stub);
        $stub = str_replace('{{route}}', $this->argument('route'), $stub);
        $stub = str_replace('{{folder-view}}', $this->argument('folder-view'), $stub);

        return $this;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if($this->argument('is_user') == "true"){
            return  '../../stubs/resourse-controller-user.stub';
        }else{
            if($this->argument('has_cover') == "true"){
                return  '../../stubs/resourse-controller-cover.stub'; 
            }

            return  '../../stubs/resourse-controller.stub';
        }
        
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers\Web';
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

        //crear modelo
        if($this->argument('db_table') != "false"){
            Artisan::call('make:modelo', [
                'name' => $this->argument('model'), 
                'table' => $this->argument('db_table')
            ]);
        }

        //crear factory
        if($this->argument('create_factory') == "true"){
            Artisan::call('make:factory-file', [
                'name' => $this->argument('model')."Factory", 
                'table' => $this->argument('db_table'),
                'model' => $this->argument('model')
            ]);

            Artisan::call('make:seeder-file', [
                'name' => $this->argument('model')."Seeder", 
                'model' => $this->argument('model')
            ]);
        }

        return $this->replaceVaribales($stub)
                ->replaceNamespace($stub, $name)
                ->replaceClass($stub, $name);
    }

    public function belongs_to_many_functions()
    {
        return '
    public function add_{{model_to_attach}}s(Request $request)
    {
        ${{var-singular}} = {{model}}::select('.chr(39).'id'.chr(39).')
                     ->where('.chr(39).'id'.chr(39).',$request->id)
                     ->firstOrFail();

        ${{var-singular}}->{{relation}}()->attach($request->{{model_to_attach}}_ids, [
            '.chr(39).'created_at'.chr(39).' => now(),
            '.chr(39).'updated_at'.chr(39).' => now()
        ]);

        
        $this->createLog("registrar", ${{var-singular}}, "{{log-singular}}", "{{route}}", ${{var-singular}}->id);
        return redirect()->back()->with('.chr(39).'success'.chr(39).', '.chr(39).'ok'.chr(39).');

    }

    public function detach_{{model_to_attach}}(${{var-singular}}_id,${{model_to_attach}}_id)
    {
        ${{var-singular}} = {{model}}::select('.chr(39).'id'.chr(39).')
                     ->where('.chr(39).'id'.chr(39).',${{var-singular}}_id)
                     ->firstOrFail();

        ${{var-singular}}->{{relation}}()->detach(${{model_to_attach}}_id);

        $this->createLog("eliminar", ${{var-singular}}, "{{log-singular}}", "{{route}}", $id);
        return $this->jsonResponse("Registro Eliminado correctamente", null, Response::HTTP_OK, null);

    }';
    }

}

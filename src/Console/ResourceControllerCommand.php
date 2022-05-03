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

        //sobrescribir archivos
        $this->overwriteFiles();

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
            return  base_path() . '/vendor/luisj/base-module/stubs/resourse-controller-user.stub';
        }else{
            if($this->argument('has_cover') == "true"){
                return  base_path() . '/vendor/luisj/base-module/stubs/resourse-controller-cover.stub'; 
            }

            return  base_path() . '/vendor/luisj/base-module/stubs/resourse-controller.stub';
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
        return null;
    }

    public function getRoutes($controller)
    {
        $route = $this->argument('route');

        return "Route::get('$route', [$controller::class, 'index'])->middleware('permission:$route.get')->name('$route');
    Route::post('$route', [$controller::class, 'store'])->middleware('permission:$route.add')->name('$route.store');
    Route::get('$route/{id}', [$controller::class, 'show'])->middleware('permission:lots.get')->name('$route.show');
    Route::get('$route/get/{id}', [$controller::class, 'get'])->middleware('permission:$route.get')->name('$route.get');
    Route::put('$route', [$controller::class, 'update'])->middleware('permission:$route.edit')->name('$route.edit');
    Route::delete('$route/{id}', [$controller::class, 'destroy'])->middleware('permission:$route.delete')->name('$route.destroy');
    
    #routes#";
    }

    public function getNamespaceString()
    {
        $controller = $this->argument('name');

        return 'use App\Http\Controllers\Web'.$controller.';
#namespace#';
    }

    public function getPermissionsCreateCode()
    {
        $ref = $this->argument('ref');
        $modulo = $this->argument('modulo');
        $log_plural = $this->argument('log-plural');

        return "Permission::create([
            'name' => '$ref.get', 
            'description' => 'Ver $log_plural', 
            'module' => '$modulo'
        ]);

        Permission::create([
            'name' => '$ref.edit', 
            'description' => 'Editar $log_plural', 
            'module' => '$modulo'
        ]);

        Permission::create(['name' => '$ref.add', 
            'description' => 'Crear $log_plural', 
            'module' => '$modulo'
        ]);

        Permission::create(['name' => '$ref.delete', 
            'description' => 'Eliminar $log_plural', 
            'module' => '$modulo'
        ]);

        #permissionsCreate#";
    
    }

    public function getPermissions()
    {
        $ref = $this->argument('ref');

        return "'$ref.get',
            '$ref.edit',
            '$ref.add',
            '$ref.delete',

            #permissions#";
    }

    public function getSeeder()
    {
        $model = $this->argument('model');

        return $model."Seeder::class,
            #seeder#";
    }

    public function overwriteFiles()
    {
        //rutas
        $controller = chr(92).$this->argument('name');
        $routes = $this->getRoutes($controller);
        $namespace = $this->getNamespaceString();

        $routes_file = file_get_contents(base_path() . '/routes/web.php');
        $routes_file = str_replace('#namespace#', $namespace, $routes_file);
        $routes_file = str_replace('#routes#', $routes, $routes_file);

        //permisos
        $permissions_create_code = $this->getPermissionsCreateCode();
        $permissions = $this->getPermissions();

        $permissions_file = file_get_contents(base_path() . '/database/seeders/PermissionsSeeder.php');
        $permissions_file = str_replace('#permissionsCreate#', $permissions_create_code, $permissions_file);
        $permissions_file = str_replace('#permissions#', $permissions, $permissions_file);

        //database seeder
        $seeder_file = file_get_contents(base_path() . '/database/seeders/DatabaseSeeder.php');
        $seeder = $this->getSeeder();
        $seeder_file = str_replace('#seeder#', $seeder, $seeder_file);

        //sobreescribir archivods
        file_put_contents(base_path() . '/routes/web.php', $routes_file);
        file_put_contents(base_path() . '/database/seeders/PermissionsSeeder.php', $permissions_file);
        file_put_contents(base_path() . '/database/seeders/DatabaseSeeder.php', $seeder_file);
    }

}

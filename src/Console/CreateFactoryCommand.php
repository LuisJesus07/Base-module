<?php

namespace LuisJ\BaseModule\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Schema;

class CreateFactoryCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:factory-file {name} {table} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea el archivo factory con el array';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Factory';

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

        return str_replace('{{factory-name}}', $this->argument('name'), $stub);
    }

    /**
     * Remplaza las variables.
     *
     * @param  string $stub
     * @return $this
     */
    protected function replaceVaribales(&$stub)
    {
        //obetener campos de la tabla dada
        $fields_array = Schema::getColumnListing($this->argument('table'));
        unset($fields_array[0]);
        unset($fields_array[array_search("updated_at", $fields_array)]);
        unset($fields_array[array_search("deleted_at", $fields_array)]);

        $factory_array = $this->get_factory_array($fields_array);
        $imports = $this->get_imports($fields_array);
        $model = $this->argument('model');


        $stub = str_replace('{{model}}', $model, $stub);
        $stub = str_replace('{{factory_array}}', $factory_array, $stub);
        $stub = str_replace('{{imports}}', $imports, $stub);
        
        return $this;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return '../../stubs/factory.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->laravel->databasePath().'/factories'.'/'.$this->argument('name').'.php';
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

    //obtener el array del factory
    public function get_factory_array($fields_array)
    {
        //crear el array array del factory
        $factory_array = "[". "\n";

        foreach ($fields_array as $field) {
            //obtener que funcion se debe de llamar de $faker
            $faker_property = $this->get_faker_property($field);

            $factory_array .= "\t\t\t"."'$field' => ".$faker_property."\n";
        }

        $factory_array .= "\t\t]";

        return $factory_array;
    }

    public function get_imports($fields_array)
    {
        $imports = "";

        foreach ($fields_array as $field) {
            $type = Schema::getColumnType($this->argument('table'),$field);

            if($type == "bigint"){
                $campo = explode("_", $field);
                unset($campo[array_search("id", $campo)]);
                $imports .= "use App\Models".chr(92).$this->dashesToCamelCase(implode("_", $campo)).";";
            }

        }

        return $imports;
    }

    public function get_faker_property($field)
    {
        $type = Schema::getColumnType($this->argument('table'),$field);

        if($type == "string"){
            return "$"."this->faker->sentence(3),";
        }

        if($type == "text"){
            return "$"."this->faker->text,";
        }

        if($type == "integer" || $type == "float"){
            return "rand(10,100),";
        }

        if($type == "boolean"){
            return "rand(0,1),";
        }

        if($type == "date"  || $type == "datetime"){
            return "$"."this->faker->dateTimeBetween('2020-08-25', '2021-08-25')->format('Y/m/d H:i:s'),";
        }

        if($type == "bigint"){
            $campo = explode("_", $field);
            unset($campo[array_search("id", $campo)]);
            $model = Helper::dashesToCamelCase(implode("_", $campo));

            return $model."::all()->random()->id,";
        }

    }

    public function dashesToCamelCase($string, $capitalizeFirstCharacter = true)
    {
        $str = str_replace('_', '', ucwords($string, '_'));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }
}

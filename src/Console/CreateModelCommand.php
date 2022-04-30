<?php

namespace LuisJ\BaseModule\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Schema;

class CreateModelCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:modelo {name} {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea el modelo de una tabla con el array fillable, softDeletes y las relaciones BelongsTo';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

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

        return str_replace('{{model-name}}', $this->argument('name'), $stub);
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
        unset($fields_array[array_search("created_at", $fields_array)]);
        unset($fields_array[array_search("updated_at", $fields_array)]);
        unset($fields_array[array_search("deleted_at", $fields_array)]);

        //obtener fillable
        $fillable = $this->get_fillable($fields_array);

        //obtener relaciones bleongsTo
        $functions = $this->get_retations_belongs_to($fields_array);

        $stub = str_replace('{{fillable_array}}', $fillable, $stub);
        $stub = str_replace('{{relations_belongs_to}}', implode($functions), $stub);
        
        return $this;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  '../../stubs/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Models';
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

    public function get_retations_belongs_to($fields_array)
    {
        $functions = array();

        //buscar las llaves foraneas para crear las relaciones
        foreach ($fields_array as $key => $field) {
            $campo = explode("_", $field);
            if(in_array("id", $campo)){
                //tomar el nombre de la relacion (y modelo relacionado)
                unset($campo[array_search("id", $campo)]);
                $relation = implode("_", $campo);
                $relation_model = chr(92).ucfirst($relation);

                $function = $key === array_key_first($fields_array) ? "" : "\t";

                $function .= "public function ".$relation."()". "\n";
                $function .= "\t{". "\n";
                $function .= "\t\treturn $".""."this->belongsTo('App\Models$relation_model');". "\n";
                $function .= "\t}". "\n";

                array_push($functions, $function);
            }
        }

        return $functions;
    }

    public function get_fillable($fields_array)
    {
        //crear el array fillable
        $fillable = "[". "\n";

        foreach ($fields_array as $field) {
            $fillable .= "\t\t"."'$field',". "\n";
        }

        $fillable .= "\t]";

        return $fillable;
    }
}

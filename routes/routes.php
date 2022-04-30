<?php 

use Illuminate\Support\Facades\Route;
use LuisJ\BaseModule\Http\Controllers\BaseModuleController;

//vista para crear modulo desde form
Route::get('luisj/base-module/create', function() {
    return view('luisj-create-module');
});

//ruta crear modulo
Route::post('create-module', [BaseModuleController::class, 'create_module']);
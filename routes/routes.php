<?php 

use Illuminate\Support\Facades\Route;
use LuisJ\BaseModule\Http\Controllers\BaseModuleController;

//verifica si la libreria esta activa
$enableViews = config('luisj-base-module.status', 'inactive');

if($enableViews == "active"){
	//vista para crear modulo desde form
	Route::get('luisj/base-module/create', function() {
	    return view('luisj-create-module::luisj-create-module');
	});

	//ruta crear modulo
	Route::post('create-module', [BaseModuleController::class, 'create_module'])->name('luisj.create.module');
}
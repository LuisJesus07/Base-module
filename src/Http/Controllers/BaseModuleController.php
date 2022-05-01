<?php

namespace LuisJ\BaseModule\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class BaseModuleController extends Controller
{
    public function create_module(Request $request)
    {
        Artisan::call('make:resourse-module', [
            'name' => $request->name, 
            'model' => $request->model,
            'modulo' => $request->modulo,
            'ref' => $request->ref, 
            'var-plural' => $request->var_plural,
            'var-singular' => $request->var_singular,
            'log-plural' => $request->log_plural, 
            'log-singular' => $request->log_singular,
            'route' => $request->route,
            'folder-view' => $request->folder_view, 
            'is_user' => $request->is_user,
            'has_cover' => $request->has_cover,
            'db_table' => $request->db_table, 
            'create_factory' => $request->create_factory,
            'has_belong_to_many' => $request->has_belong_to_many,
            'model_to_attach' => $request->model_to_attach,
            'relation' => $request->relation,
        ]);

        return redirect()->back();
    }
}

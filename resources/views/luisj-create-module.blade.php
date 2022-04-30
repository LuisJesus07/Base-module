<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Crear Modulo</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    </head>
    <body class="font-sans antialiased">
      
          <div class="container">
            <form class="well form-horizontal" action="{{ route('create.module') }}" method="POST">
                @csrf
                <fieldset>
                  <!-- Form Name -->
                  <legend><center><h2><b>Crear modulo</b></h2></center></legend><br>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label">Nombre del controlador</label>  
                    <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input  name="name" placeholder="UserController" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Nombre del modelo</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="model" placeholder="User" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Nombre del modulo</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="modulo" placeholder="Usuarios" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Ref(nombre del permiso)</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="ref" placeholder="users" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Variable en plural</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="var_plural" placeholder="users" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Variable en singular</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="var_singular" placeholder="user" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Log en plural</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="log_plural" placeholder="usuarios" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Log en singular</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="log_singular" placeholder="usuario" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Ruta</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="route" placeholder="users" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Nombre del folder de views</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="folder_view" placeholder="users" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Nombre de la tabla(BD)</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="db_table" placeholder="users" class="form-control"  type="text">
                      </div>
                    </div>
                  </div>

                  <!-- Select input-->

                  <div class="form-group"> 
                    <label class="col-md-4 control-label">Es usuario?(cliente, etc.)</label>
                      <div class="col-md-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <select name="is_user" class="form-control selectpicker">
                              <option value="true">true</option>
                              <option value="false">false</option>
                            </select>
                        </div>
                      </div>
                  </div>

                  <!-- Select input-->

                  <div class="form-group"> 
                    <label class="col-md-4 control-label">Tiene image cover?</label>
                      <div class="col-md-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <select name="has_cover" class="form-control selectpicker">
                              <option value="true">true</option>
                              <option value="false">false</option>
                            </select>
                        </div>
                      </div>
                  </div>

                  <!-- Select input-->

                  <div class="form-group"> 
                    <label class="col-md-4 control-label">Crear factory</label>
                      <div class="col-md-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <select name="create_factory" class="form-control selectpicker">
                              <option value="true">true</option>
                              <option value="false">false</option>
                            </select>
                        </div>
                      </div>
                  </div>

                  <!-- Select input-->

                  <div class="form-group"> 
                    <label class="col-md-4 control-label">Tiene relacion belongs to many?</label>
                      <div class="col-md-4 selectContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <select name="has_belong_to_many" class="form-control selectpicker">
                              <option value="true">true</option>
                              <option value="false">false</option>
                            </select>
                        </div>
                      </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Model to attach</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="model_to_attach" placeholder="users" class="form-control"  type="text" value="false">
                      </div>
                    </div>
                  </div>

                  <!-- Text input-->

                  <div class="form-group">
                    <label class="col-md-4 control-label" >Relation</label> 
                      <div class="col-md-4 inputGroupContainer">
                      <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="relation" placeholder="users" class="form-control"  type="text" value="false">
                      </div>
                    </div>
                  </div>
                    
                  <!-- Button -->
                  <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4"><br>
                      &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="submit" class="btn btn-warning" >&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSUBMIT <span class="glyphicon glyphicon-send"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</button>
                    </div>
                  </div>

                </fieldset>
            </form>
          </div>

    </body>
</html>

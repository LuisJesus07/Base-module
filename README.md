## Base Module Laravel
Herramienta para crear la base de un modulo (crud) atravez de una interface grafica en el framework de laravel. Este te permite crear:
1. El controlador con los metodos base hechos (index, store, show, get, update, delete).
2. Los permisos
3. Las rutas
4. El modelo (con los campos de la tabla y las relaciones belongsTo)
5. El factory (con los campos de la tabla, de acuerdo al tipo de campo)
6. El seeder

Asi como tambien un comando para crear una clase mail, con el modelo y su vista relacionada

## Instalación
Instala la libreria con composer:
```bash
composer luisj/base-module
```
Una vez instalada, agrega en el array de providers (config/app.php) la clase:
```php
LuisJ\BaseModule\BaseModuleServiceProvider::class,
```
Luego, publica el archivo de configuraciones y recarga la cache:
```bash
php artisan vendor:publish --tag="luisj-base-module-config"
php artisan config:clear
```
Por ultimo, en el archivo .env agrega la siguiente variable:
```env
LUISJ_BASE_MODULE_STATUS={status}
```
este status puede tener los siguientes valores
1. active (para tener disponible la libreria)
2. inactive (para desactivar la libreria)

## Instrucciones de uso
El primero paso es crear la migracion de tu modulo. ejemplo:

Modulo de clientes, con los campos
1. name 
2. phone_number 
3. age 
4. email

Una vez creada (y ejecutada) la migracion, para poder crear la base del modulo, dirigete a la sigiente ruta
```php
'/luisj/base-module/create'
```
Ahi se mostrara un formluario, en cual pedira diversa informacion para la creacion del modulo (nombre del controlador a crear, nombre del modelo etc..).

Al darle submit al formulario, se crearan los archivos mencionados anteriormente.

## Otros comandos
Comando para crear una clase mail, con vista y modelo relacionado
```bash
php artisan make:correo {name} {model} {var-singular} {subject}
```
1. name (Nombre de la clase, ejemplo WelcomeClientEmail)
2. model (Modelo que se usara en el mail, ejemplo Client)
3. var-singular (Nombre de la variable a usar, ejemplo client)
4. subject (Asunto del correo, ejemplo "Bienvenido cliente")

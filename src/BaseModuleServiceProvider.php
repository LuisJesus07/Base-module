<?php 

namespace LuisJ\BaseModule;

use Illuminate\Support\ServiceProvider;
use LuisJ\BaseModule\Console\ResourceControllerCommand;
use LuisJ\BaseModule\Console\CreateModelCommand;
use LuisJ\BaseModule\Console\CreateFactoryCommand;
use LuisJ\BaseModule\Console\CreateSeederCommand;
use LuisJ\BaseModule\Console\CreateMailCommand;
use LuisJ\BaseModule\Console\CreateMailViewCommand;

/**
 * 
 */
class BaseModuleServiceProvider extends ServiceProvider
{
	/**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
    	$this->loadConfig();
        $this->loadCommands();
        $this->loadRoutes();
        $this->loadViews();
    }

    private function loadConfig(): void
	{
	    $this->publishes(
	        [
	            base_path() . '/vendor/luisj/base-module/config/luisj-base-module.php' => config_path('base-module.php'),
	        ],
	        'luisj-base-module-config'
	    );
	}

    private function loadCommands(): void
	{
        $this->commands([
            ResourceControllerCommand::class,
	        CreateModelCommand::class,
	        CreateFactoryCommand::class,
	        CreateSeederCommand::class,
	        CreateMailCommand::class,
	        CreateMailViewCommand::class,
        ]);
	}

	private function loadRoutes(): void
	{
	    $this->loadRoutesFrom(base_path() . '/vendor/luisj/base-module/routes/routes.php');
	}

	private function loadViews(): void
	{
	    $this->loadViewsFrom(base_path() . '/vendor/luisj/base-module/resources/views', 'luisj-create-module');

	}
}
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
        $this->loadCommands();
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
}
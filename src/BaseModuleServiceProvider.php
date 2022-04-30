<?php 

namespace Laravel\BaseModule;

use Illuminate\Support\ServiceProvider;
use Laravel\BaseModule\Console\ResourceControllerCommand;
use Laravel\BaseModule\Console\CreateModelCommand;
use Laravel\BaseModule\Console\CreateFactoryCommand;
use Laravel\BaseModule\Console\CreateSeederCommand;
use Laravel\BaseModule\Console\CreateMailCommand;
use Laravel\BaseModule\Console\CreateMailViewCommand;

/**
 * 
 */
class ClassName extends ServiceProvider
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
	    if ($this->app->runningInConsole()) {
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
}
<?php 

namespace evidenceekanem\LaravelTinify;

use Illuminate\Support\ServiceProvider;
use evidenceekanem\LaravelTinify\Facades\Tinify;
use evidenceekanem\LaravelTinify\Services\TinifyService;
class LaravelTinifyServiceProvider extends ServiceProvider {

	/**
	* Indicates if loading of the provider is deferred.
	*
	* @var bool
	*/
	protected $defer = false;

	/**
	* Register custom form macros on package start
	* @return void
	*/
	public function boot()
	{	
	}

	/**
	* Register the service provider.
	*
	* @return void
	*/
	public function register()
	{
		$configPath = __DIR__ . '/../config/tinify.php';
        $this->mergeConfigFrom($configPath, 'tinify');

		$this->publishes([$configPath => config_path('tinify.php')], 'config');

		$this->app->bind(Tinify::class, function () {
            return TinifyService::create(config('tinify'));
        });
	}

	/**
	* Get the services provided by the provider.
	*
	* @return array
	*/
	public function provides()
	{
		return array();
	}

}
<?php namespace Goodspb\Laravel5Ucpaas;

use Illuminate\Support\ServiceProvider;

class Laravel5UcpaasServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
			__DIR__.'/config/ucpaas.php' => config_path('ucpaas.php'),
		]);
		$this->mergeConfigFrom(__DIR__.'/config/ucpaas.php', 'ucpaas');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('ucpaas', function ($app) {
			return new ucpaas($app);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}

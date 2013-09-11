<?php namespace Conarwelsh\MustacheL4;

use Illuminate\Support\ServiceProvider;

class MustacheL4ServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->package('conarwelsh/mustache-l4');

		$app = $this->app;

		$extension = $app['config']->get('mustache-l4::config.extension');
		$extension ?: 'mustache';

		$app->extend('view.engine.resolver', function($resolver, $app) use ($extension)
		{
			$resolver->register($extension, function() use($app)
			{
				return $app->make('Conarwelsh\MustacheL4\MustacheEngine');
			});

			return $resolver;
		});

		$app->extend('view', function($env, $app) use ($extension)
		{
			$env->addExtension($extension, $extension);
			return $env;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('mustache-l4');
	}

}
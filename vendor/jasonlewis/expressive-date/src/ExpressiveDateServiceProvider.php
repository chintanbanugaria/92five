<?php

use Illuminate\Support\ServiceProvider;

class ExpressiveDateServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 * 
	 * @return void
	 */
	public function register()
	{
		$this->app['date'] = function($app)
		{
			return new ExpressiveDate;
		};
	}

}
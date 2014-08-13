<?php

namespace Kmd\Logviewer;

use Illuminate\Support\ServiceProvider;

class LogviewerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @access protected
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @access public
     * @return void
     */
    public function boot()
    {
        $this->package('kmd/logviewer');

        include __DIR__.'/../../routes.php';
        include __DIR__.'/../../filters.php';
        include __DIR__.'/../../macros.php';
    }

    /**
     * Register the service provider.
     *
     * @access public
     * @return void
     */
    public function register()
    {
        $this->app['logviewer'] = $this->app->share(function ($app) {
            return new Logviewer;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @access public
     * @return array
     */
    public function provides()
    {
        return array('logviewer');
    }
}

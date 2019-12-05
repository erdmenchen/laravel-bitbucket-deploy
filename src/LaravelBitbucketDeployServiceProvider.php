<?php

namespace Erdmenchen\LaravelBitbucketDeploy;

use Illuminate\Support\ServiceProvider;

class LaravelBitbucketDeployServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/deploy-manifest.json' => base_path('deploy-manifest.json'),
            //__DIR__ . '/config' => config_path('laravel-bitbucket-deploy'),
        ]);
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
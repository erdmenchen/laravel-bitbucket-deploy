<?php

namespace Erdmenchen\LaravelBitbucketDeploy\Test;

use Erdmenchen\LaravelBitbucketDeploy\LaravelBitbucketDeployFacade;
use Erdmenchen\LaravelBitbucketDeploy\LaravelBitbucketDeployServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();
    }
    /**
     * Load package service provider
     * @param  \Illuminate\Foundation\Application $app
     * @return Erdmenchen\LaravelBitbucketDeploy\LaravelBitbucketDeployServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [LaravelBitbucketDeployServiceProvider::class];
    }
    /**
     * Load package alias
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            //'LaravelBitbucketDeploy' => LaravelBitbucketDeployFacade::class,
        ];
    }
}
<?php

namespace IcehouseVentures\LaravelChartjs\Tests;

use IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            ChartjsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        // Set other environment variables
        putenv('APP_ENV=testing');
        putenv('APP_DEBUG=true');
    }
}

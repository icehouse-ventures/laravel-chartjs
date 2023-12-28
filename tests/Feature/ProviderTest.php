<?php

use IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider;
use Illuminate\Support\Facades\File;

it('registers the package provider', function () {

    // Assert that the application instance exists
    $this->assertNotNull(app());

    // Assert that the package provider class exists
    $this->assertTrue(class_exists(ChartjsServiceProvider::class));

    // Assert that the package provider is registered
    $this->assertTrue(in_array(ChartjsServiceProvider::class, array_keys(app()->getLoadedProviders()), true));

    // Assert that the package provider is loaded
    $this->assertInstanceOf(ChartjsServiceProvider::class, app()->getProvider(ChartjsServiceProvider::class));
});

it('publishes assets', function () {
    // Install the service provider
    $this->artisan('vendor:publish', [
        '--provider' => ChartjsServiceProvider::class,
        '--tag' => 'assets',
    ]);

    // Assert that the assets have been published
    $this->assertFileExists(public_path('vendor/laravelchartjs/chart.js'));
});

it('publishes configuration', function () {
    // Install the service provider
    $this->artisan('vendor:publish', [
        '--provider' => ChartjsServiceProvider::class,
        '--tag' => 'config',
    ]);

    // Assert that the config file has been published
    $this->assertFileExists(config_path('chartjs.php'));
});

it('publishes views', function () {
    // Install the service provider
    $this->artisan('vendor:publish', [
        '--provider' => ChartjsServiceProvider::class,
        '--tag' => 'views',
    ]);

    // Assert that the views have been published
    $this->assertFileExists(resource_path('views/vendor/laravelchartjs/custom-chart-template.blade.php'));
});

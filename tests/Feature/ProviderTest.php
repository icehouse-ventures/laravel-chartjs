<?php

use IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider;

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
    foreach ([
        'assets' => 'chart.js',
        'assets-v3' => 'chart3.js',
        'assets-v2' => 'chart2.bundle.js',
    ] as $tag => $file) {
        $this->artisan('vendor:publish', [
            '--provider' => ChartjsServiceProvider::class,
            '--tag' => $tag,
        ]);

        $this->assertFileExists(public_path('vendor/laravelchartjs/'.$file));
    }
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
        '--force' => true,
    ]);

    // Assert that the views have been published
    $this->assertFileExists(resource_path('views/vendor/laravelchartjs/chart-template.blade.php'));
    $this->assertFileExists(resource_path('views/vendor/laravelchartjs/chart-scripts.blade.php'));
});

it('loads major-pinned CDN assets and a compatible date adapter', function () {
    config()->set('chartjs.delivery', 'cdn');
    config()->set('chartjs.version', 4);
    config()->set('chartjs.date_adapter', 'luxon');

    $html = app('chartjs')
        ->name('chart1')
        ->render()
        ->render();

    expect($html)
        ->toContain('chart.js@4/dist/chart.umd.min.js')
        ->toContain('luxon@3/build/global/luxon.min.js')
        ->toContain('chartjs-adapter-luxon@1');
});

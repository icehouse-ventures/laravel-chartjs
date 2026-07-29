<?php

namespace IcehouseVentures\LaravelChartjs\Providers;

use IcehouseVentures\LaravelChartjs\Builder;
use IcehouseVentures\LaravelChartjs\Support\Config;
use IcehouseVentures\LaravelChartjs\View\Components\ChartjsComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ChartjsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Installation and setup
        $this->publishes([
            __DIR__.'/../../config/chartjs.php' => config_path('chartjs.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/laravelchartjs'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../dist/chart.js' => public_path('vendor/laravelchartjs/chart.js'),
        ], 'assets');

        $this->publishes([
            __DIR__.'/../../dist/chart3.js' => public_path('vendor/laravelchartjs/chart3.js'),
        ], 'assets-v3');

        $this->publishes([
            __DIR__.'/../../dist/chart2.bundle.js' => public_path('vendor/laravelchartjs/chart2.bundle.js'),
        ], 'assets-v2');

        // Delivery and view injection
        if (Config::deliveryMethod() === 'binary') {
            $templates = [
                'laravelchartjs::chart-template',
                'laravelchartjs::chart-template-livewire',
            ];

            if (Config::chartJsVersion() >= 4) {
                view()->composer($templates, function ($view) {
                    $view->with('chartJsScriptv4', file_get_contents(base_path('vendor/icehouse-ventures/laravel-chartjs/dist/chart.js')));
                });
            } elseif (Config::chartJsVersion() === 3) {
                view()->composer($templates, function ($view) {
                    $view->with('chartJsScriptv3', file_get_contents(base_path('vendor/icehouse-ventures/laravel-chartjs/dist/chart3.js')));
                });
            } else {
                view()->composer($templates, function ($view) {
                    $view->with('chartJsScriptv2', file_get_contents(base_path('vendor/icehouse-ventures/laravel-chartjs/dist/chart2.bundle.js')));
                });
            }
        }

        // Register our Blade component
        Blade::component('chartjs-component', ChartjsComponent::class);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravelchartjs');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('chartjs', function () {
            return new Builder;
        });

        $this->app->singleton('chartjs-facade', function () {
            return new Builder;
        });
    }
}

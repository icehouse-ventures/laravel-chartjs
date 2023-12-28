<?php namespace IcehouseVentures\LaravelChartJs\Providers;

use IcehouseVentures\LaravelChartJs\Builder;
use IcehouseVentures\LaravelChartJs\ChartBar;
use IcehouseVentures\LaravelChartJs\ChartLine;
use IcehouseVentures\LaravelChartJs\ChartPieAndDoughnut;
use IcehouseVentures\LaravelChartJs\ChartRadar;
use IcehouseVentures\LaravelChartJs\Support\Config;
use Illuminate\Support\ServiceProvider;

class ChartJsServiceProvider extends ServiceProvider
{
    /**
     * Array with colours configuration of the chartjs config file
     * @var array
     */
    protected $colours = [];

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'chart-template');
        
        $this->colours = config('chartjs.colours');

        // Installation and setup

        $this->publishes([
            __DIR__.'/../../config/chart-js.php' => config_path('chart-js.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views/chart-template.blade.php' => resource_path('views/vendor/laravelchartjs/custom-chart-template.blade.php'),
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

        if(config('chart-js.delivery') == 'binary'){
            if(config('chart-js.version') == 4)
                view()->composer('chart-template::chart-template', function ($view) {
                    $view->with('chartJsScriptv3', file_get_contents(base_path('vendor/icehouse-ventures/laravel-chartjs/dist/chart.js')));
                });
            if(config('chart-js.version') == 3)
                view()->composer('chart-template::chart-template', function ($view) {
                    $view->with('chartJsScriptv3', file_get_contents(base_path('vendor/icehouse-ventures/laravel-chartjs/dist/chart3.js')));
                });
            else{
                view()->composer('chart-template::chart-template', function ($view) {
                    $view->with('chartJsScriptv2', file_get_contents(base_path('vendor/icehouse-ventures/laravel-chartjs/dist/chart2.bundle.js')));
                });
            }
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('chartjs', function() {
            return new Builder();
        });
    }
}

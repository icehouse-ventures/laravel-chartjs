<?php namespace IcehouseVentures\LaravelChartJs\Providers;

use IcehouseVentures\LaravelChartJs\Builder;
use IcehouseVentures\LaravelChartJs\ChartBar;
use IcehouseVentures\LaravelChartJs\ChartLine;
use IcehouseVentures\LaravelChartJs\ChartPieAndDoughnut;
use IcehouseVentures\LaravelChartJs\ChartRadar;
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

        $this->publishes([
            __DIR__.'/../../config/chart-js.php' => config_path('chart-js.php'),
        ], 'config');

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

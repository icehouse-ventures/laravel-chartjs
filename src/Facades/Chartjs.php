<?php

namespace IcehouseVentures\LaravelChartjs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \IcehouseVentures\LaravelChartjs\Builder build()
 */
class Chartjs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'chartjs-facade';
    }
}
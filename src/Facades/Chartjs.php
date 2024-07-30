<?php

namespace IcehouseVentures\LaravelChartjs\Facades;

use Illuminate\Support\Facades\Facade;

class Chartjs extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'chartjs';
    }
}
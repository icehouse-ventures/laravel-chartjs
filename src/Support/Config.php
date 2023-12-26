<?php

namespace IcehouseVentures\LaravelChartJs\Support;

class Config
{
    public static function allowedChartTypes($version = null)
    {
        if($version > 3){
            return ['bar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];
        }
        return ['bar', 'horizontalBar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];
    }

    public static function chartJsVersion()
    {
        return config('chart-js.version') ?? 2;
    }
    

}

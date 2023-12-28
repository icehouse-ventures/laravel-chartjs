<?php

namespace IcehouseVentures\LaravelChartJs\Support;

use Illuminate\Support\Facades\File;

class Config
{
    public static function allowedChartTypes()
    {
        if(self::chartJsVersion() > 3){
            return ['bar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];
        }
        return ['bar', 'horizontalBar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];
    }

    public static function chartJsVersion()
    {
        return config('chart-js.version') ?? 2;
    }
    
    public static function deliveryMethod()
    {
        return config('chart-js.delivery') ?? 'custom';
    }

    public static function useCustomView()
    {
        if(!config('chart-js.custom_view')){
            return false;
        }
        if(config('chart-js.custom_view') === 'false'){
            return false;
        }
        if(config('chart-js.custom_view')){
            return true;
        }
        return false;
    }

    public static function getChartViewName()
    {
        if (self::useCustomView()) {
            $customViewPath = resource_path('views/vendor/laravelchartjs/custom-chart-template.blade.php');
            if (File::exists($customViewPath)) {
                return 'vendor.laravelchartjs.custom-chart-template';
            }
        }

        return 'chart-template::chart-template';
    }

}

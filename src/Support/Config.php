<?php

namespace IcehouseVentures\LaravelChartjs\Support;

use Illuminate\Support\Facades\File;

class Config
{
    public static function allowedChartTypes()
    {
        if(self::chartJsVersion() > 3) {
            return ['bar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];
        }
        return ['bar', 'horizontalBar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];
    }

    public static function chartJsVersion()
    {
        return config('chartjs.version', 2);
    }

    public static function deliveryMethod()
    {
        return config('chartjs.delivery', 'CDN');
    }

    public static function useCustomView()
    {
        if(!config('chartjs.custom_view')) {
            return false;
        }
        if(config('chartjs.custom_view') === 'false') {
            return false;
        }
        if(config('chartjs.custom_view')) {
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

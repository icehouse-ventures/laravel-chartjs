<?php

namespace IcehouseVentures\LaravelChartjs\Support;

use Illuminate\Support\Facades\File;

class Config
{
    public static function allowedChartTypes()
    {
        $base_types = ['bar', 'horizontalBar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];

        if (self::chartJsVersion() > 3) {
            $base_types = ['bar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];
        }

        return array_merge($base_types, array_keys(config('chartjs.custom_chart_types', [])));
    }

    public static function chartJsVersion()
    {
        return config('chartjs.version', 2);
    }

    public static function deliveryMethod()
    {
        return config('chartjs.delivery', 'CDN');
    }

    public static function dateAdapter()
    {
        return config('chartjs.date_adapter', 'none');
    }

    public static function useCustomView()
    {
        if (!config('chartjs.custom_view')) {
            return false;
        }

        if (config('chartjs.custom_view') === 'false') {
            return false;
        }

        if (config('chartjs.custom_view')) {
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

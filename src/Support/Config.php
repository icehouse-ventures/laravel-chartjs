<?php

namespace IcehouseVentures\LaravelChartjs\Support;

class Config
{
    /** @return list<string> */
    public static function allowedChartTypes(): array
    {
        $base_types = ['bar', 'horizontalBar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];

        if (self::chartJsVersion() >= 3) {
            $base_types = ['bar', 'bubble', 'scatter', 'doughnut', 'line', 'pie', 'polarArea', 'radar'];
        }

        $customTypes = array_map(
            static fn (int|string $type): string => (string) $type,
            array_keys((array) config('chartjs.custom_chart_types', []))
        );

        return [...$base_types, ...$customTypes];
    }

    public static function chartJsVersion(): int
    {
        return (int) config('chartjs.version', 4);
    }

    public static function deliveryMethod(): string
    {
        return strtolower((string) config('chartjs.delivery', 'custom'));
    }

    public static function dateAdapter(): string
    {
        return strtolower((string) config('chartjs.date_adapter', 'none'));
    }
}

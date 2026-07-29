<?php

namespace IcehouseVentures\LaravelChartjs\View\Components;

use IcehouseVentures\LaravelChartjs\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChartjsComponent extends Component
{
    public Builder $chart;

    public function __construct(Builder $chart)
    {
        $this->chart = $chart;
    }

    public function render(): View
    {
        return $this->chart->render();
    }
}

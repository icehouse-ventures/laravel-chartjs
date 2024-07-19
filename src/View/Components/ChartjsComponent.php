<?php

namespace IcehouseVentures\LaravelChartjs\View\Components;

use Illuminate\View\Component;

class ChartjsComponent extends Component
{
    public $chart;

    public function __construct($chart)
    {
        $this->chart = $chart;
    }

    public function render()
    {
        return $this->chart->render();
    }
}

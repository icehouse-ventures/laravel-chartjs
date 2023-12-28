<?php

/*
 * This file is inspired by Builder from Laravel Chartjs - Brian Faust and Laravel Chartjs - Felix Costa
 */

namespace IcehouseVentures\LaravelChartjs;

use Illuminate\Support\Arr;
use IcehouseVentures\LaravelChartjs\Support\Config;

class Builder
{
    /**
     * @var array
     */
    private $charts = [];

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $defaults;

    /**
     * @var array
     */
    private $types;

    public function __construct()
    {
        $this->defaults = [
            'datasets' => [],
            'labels'   => [],
            'type'     => 'line',
            'options'  => [],
            'size'     => ['width' => null, 'height' => null],
            'plugins'  => []
        ];

        $this->version = Config::chartJsVersion();

        $this->delivery = Config::deliveryMethod();

        $this->types = Config::allowedChartTypes();

        $this->useCustomView = Config::useCustomView();

        $this->chartViewName = Config::getChartViewName();
    }

    /**
     * @param $name
     *
     * @return $this|Builder
     */
    public function name($name)
    {
        $this->name = $name;
        $this->charts[$name] = $this->defaults;
        return $this;
    }

    /**
     * @param $element
     *
     * @return Builder
     */
    public function element($element)
    {
        return $this->set('element', $element);
    }

    /**
     * @param array $labels
     *
     * @return Builder
     */
    public function labels(array $labels)
    {
        return $this->set('labels', $labels);
    }

    /**
     * @param array $datasets
     *
     * @return Builder
     */
    public function datasets(array $datasets)
    {
        return $this->set('datasets', $datasets);
    }

    /**
     * @param $type
     *
     * @return Builder
     */
    public function type($type)
    {
        if (!in_array($type, $this->types)) {
            throw new \InvalidArgumentException('Invalid Chart type.');
        }
        return $this->set('type', $type);
    }

    /**
     * @param array $size
     *
     * @return Builder
     */
    public function size($size)
    {
        return $this->set('size', $size);
    }

    /**
     * @param array $options
     *
     * @return $this|Builder
     */
    public function options(array $options)
    {
        foreach ($options as $key => $value) {
            $this->set('options.' . $key, $value);
        }

        return $this;
    }

    /**
     *
     * @param string|array $optionsRaw
     * @return \self
     */
    public function optionsRaw($optionsRaw)
    {
        if (is_array($optionsRaw)) {
            $this->set('optionsRaw', json_encode($optionsRaw, true));
            return $this;
        }

        $this->set('optionsRaw', $optionsRaw);
        return $this;
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $chart = $this->charts[$this->name];
        $view = $this->useCustomView ?  $this->chartViewName : 'chart-template::chart-template';
        $optionsRaw = isset($chart['optionsRaw']) ? $chart['optionsRaw'] : '';        
        $optionsSimple = isset($chart['options']) ? json_encode($chart['options']) : '';
        $options =  $optionsRaw ? $optionsRaw : $optionsSimple;

        return view($view)->with([
                    'datasets' => json_encode($chart['datasets']),
                    'element' => $this->name,
                    'labels' => json_encode($chart['labels']),
                    'options' => $options,
                    'type' => $chart['type'],
                    'size' => $chart['size'],
                    'version' => $this->version,
                    'delivery' => $this->delivery
                ]);
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    private function get($key)
    {
        return Arr::get($this->charts[$this->name], $key);
    }

    /**
     * @param $key
     * @param $value
     *
     * @return $this|Builder
     */
    private function set($key, $value)
    {
        Arr::set($this->charts[$this->name], $key, $value);

        return $this;
    }
}

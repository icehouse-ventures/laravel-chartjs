<?php

/*
 * This file is inspired by Builder from Laravel Chartjs - Brian Faust and Laravel Chartjs - Felix Costa
 */

namespace IcehouseVentures\LaravelChartjs;

use IcehouseVentures\LaravelChartjs\Support\Config;
use Illuminate\Support\Arr;

class Builder
{
    /**
     * @var array
     */
    public $charts = [];

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    private $defaults;

    /**
     * @var array
     */
    private $types;

    /**
     * @var bool
     */
    public $inLivewire = false;

    /**
     * @var string
     */
    public $model = false;

    public function __construct()
    {
        $this->defaults = [
            'datasets' => [],
            'labels' => [],
            'type' => 'line',
            'options' => [],
            'size' => ['width' => null, 'height' => null],
            'plugins' => [],
        ];

        $this->types = Config::allowedChartTypes();
    }

    /**
     * @return Builder
     */
    public function build()
    {
        return new self();
    }

    /**
     * @return Builder
     */
    public function name($name)
    {
        $this->name = $name;
        $this->charts[$name] = $this->defaults;
        return $this;
    }

    /**
     * @return Builder
     */
    public function livewire()
    {
        return $this->set('inLivewire', true);
    }

    /**
     * @return Builder
     */
    public function model($model)
    {
        return $this->set('model', $model);
    }

    /**
     * @return Builder
     */
    public function element($element)
    {
        return $this->set('element', $element);
    }

    /**
     * @return Builder
     */
    public function labels(array $labels)
    {
        return $this->set('labels', $labels);
    }

    /**
     * @return Builder
     */
    public function datasets(array $datasets)
    {
        return $this->set('datasets', $datasets);
    }

    /**
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
     * @param  array  $size
     * @return Builder
     */
    public function size($size)
    {
        return $this->set('size', $size);
    }

    /**
     * @return Builder
     */
    public function options(array $options)
    {
        foreach ($options as $key => $value) {
            $this->set('options.' . $key, $value);
        }

        return $this;
    }

    /**
     * @return Builder
     */
    public function optionsRaw(string|array $optionsRaw)
    {
        if (is_array($optionsRaw)) {
            $this->set('optionsRaw', json_encode($optionsRaw, JSON_THROW_ON_ERROR));
            return $this;
        }

        // Validate that the string contains valid JavaScript object syntax
        $this->validateJavaScriptOptions($optionsRaw);
        
        $this->set('optionsRaw', $optionsRaw);

        return $this;
    }

    /**
     * Validates JavaScript options for common issues
     * 
     * @param string $options
     * @throws \InvalidArgumentException
     */
    private function validateJavaScriptOptions(string $options)
    {
        $trimmed = trim($options);
        
        // Check if it starts and ends with braces
        if (!str_starts_with($trimmed, '{') || !str_ends_with($trimmed, '}')) {
            throw new \InvalidArgumentException('optionsRaw must be a valid JavaScript object (should start with { and end with })');
        }
        
        // Check for common mistakes
        if (str_contains($options, 'function(') && str_contains($options, '"function(')) {
            throw new \InvalidArgumentException('JavaScript functions should not be quoted in optionsRaw');
        }
        
        // Try to detect if it's meant to be JSON but contains functions
        if (preg_match('/^\s*{\s*"/', $trimmed) && str_contains($options, 'function(')) {
            // This looks like JSON syntax but contains functions - warn the user
            // This is actually valid JavaScript, so we'll allow it but could add a warning in the future
        }
    }

    /**
     * @return mixed
     */
    public function render()
    {
        $chart = $this->charts[$this->name];
        $inLivewire = $chart['inLivewire'] ?? (class_exists('Livewire\\Livewire') ? \Livewire\Livewire::isLivewireRequest() : false);
        $view = ($inLivewire ? 'laravelchartjs::chart-template-livewire' : 'laravelchartjs::chart-template');

        $optionsFallback = "{}";

        $optionsSimple = $chart['options'] ? json_encode($chart['options'], JSON_THROW_ON_ERROR) : null;

        $options = $chart['optionsRaw'] ?? $optionsSimple ?? $optionsFallback;


        return view($view)->with([
            'datasets' => json_encode($chart['datasets']),
            'element' => $this->name,
            'inLivewire' => $inLivewire,
            'model' => $chart['model'] ?? false,
            'labels' => json_encode($chart['labels']),
            'options' => $options,
            'type' => $chart['type'],
            'size' => $chart['size'],
            'version' => Config::chartJsVersion(),
            'delivery' => Config::deliveryMethod(),
            'date_adapter' => Config::dateAdapter(),
        ]);
    }

    /**
     * @return mixed
     */
    public function get($key)
    {
        return Arr::get($this->charts[$this->name], $key);
    }

    /**
     * @return Builder
     */
    public function set($key, $value)
    {
        Arr::set($this->charts[$this->name], $key, $value);

        return $this;
    }
}

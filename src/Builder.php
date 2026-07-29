<?php

/*
 * This file is inspired by Builder from Laravel Chartjs - Brian Faust and Laravel Chartjs - Felix Costa
 */

namespace IcehouseVentures\LaravelChartjs;

use IcehouseVentures\LaravelChartjs\Support\Config;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Livewire\Livewire;
use LogicException;

class Builder
{
    /** @var array<string, array<string, mixed>> */
    public array $charts = [];

    public ?string $name = null;

    /** @var array<string, mixed> */
    private array $defaults;

    /** @var list<string> */
    private array $types;

    public bool $inLivewire = false;

    public string|false $model = false;

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

    public function build(): self
    {
        return new self;
    }

    public function name(string $name): self
    {
        if ($name === '') {
            throw new InvalidArgumentException('The chart name must be a non-empty string.');
        }

        $this->name = $name;
        $this->charts[$name] = $this->defaults;

        return $this;
    }

    public function livewire(): self
    {
        return $this->set('inLivewire', true);
    }

    public function model(string $model): self
    {
        return $this->set('model', $model);
    }

    public function element(string $element): self
    {
        return $this->set('element', $element);
    }

    /** @param array<int, mixed> $labels */
    public function labels(array $labels): self
    {
        return $this->set('labels', $labels);
    }

    /** @param array<int, array<string, mixed>> $datasets */
    public function datasets(array $datasets): self
    {
        return $this->set('datasets', $datasets);
    }

    public function type(string $type): self
    {
        if (! in_array($type, $this->types, true)) {
            throw new InvalidArgumentException('Invalid chart type.');
        }

        return $this->set('type', $type);
    }

    /** @param array{width?: int|null, height?: int|null} $size */
    public function size(array $size): self
    {
        return $this->set('size', $size);
    }

    /** @param array<string, mixed> $options */
    public function options(array $options): self
    {
        foreach ($options as $key => $value) {
            $this->set('options.'.$key, $value);
        }

        return $this;
    }

    /** @param string|array<string, mixed> $optionsRaw */
    public function optionsRaw(string|array $optionsRaw): self
    {
        if (is_array($optionsRaw)) {
            $this->set('optionsRaw', $this->encodeJson($optionsRaw));

            return $this;
        }

        $this->set('optionsRaw', $optionsRaw);

        return $this;
    }

    public function render(): View
    {
        $name = $this->currentChartName();

        if (! isset($this->charts[$name])) {
            throw new LogicException('Name the chart before rendering it.');
        }

        $chart = $this->charts[$name];
        $inLivewire = $chart['inLivewire'] ?? (class_exists('Livewire\\Livewire') ? Livewire::isLivewireRequest() : false);
        $view = ($inLivewire ? 'laravelchartjs::chart-template-livewire' : 'laravelchartjs::chart-template');

        $optionsSimple = $chart['options'] ? $this->encodeJson($chart['options']) : null;
        $options = $chart['optionsRaw'] ?? $optionsSimple ?? '{}';

        return view($view)->with([
            'datasets' => $this->encodeJson($chart['datasets']),
            'element' => $chart['element'] ?? $name,
            'inLivewire' => $inLivewire,
            'model' => $chart['model'] ?? false,
            'labels' => $this->encodeJson($chart['labels']),
            'options' => $options,
            'type' => $chart['type'],
            'size' => $chart['size'],
            'version' => Config::chartJsVersion(),
            'delivery' => Config::deliveryMethod(),
            'date_adapter' => Config::dateAdapter(),
        ]);
    }

    public function get(string $key): mixed
    {
        return Arr::get($this->charts[$this->currentChartName()], $key);
    }

    public function set(string $key, mixed $value): self
    {
        Arr::set($this->charts[$this->currentChartName()], $key, $value);

        return $this;
    }

    /** @param array<mixed> $value */
    private function encodeJson(array $value): string
    {
        return json_encode(
            $value,
            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_THROW_ON_ERROR
        );
    }

    private function currentChartName(): string
    {
        if ($this->name === null) {
            throw new LogicException('Name the chart before configuring it.');
        }

        return $this->name;
    }
}

<?php

use IcehouseVentures\LaravelChartjs\Builder;

test('it can set name', function () {
    $builder = new Builder();
    $result = $builder->name('chart1');

    expect($result)->toBeInstanceOf(Builder::class);
    // Use the builder class variable method
    expect($builder->name)->toBe('chart1');
});

test('it can set element', function () {
    $builder = new Builder();
    $result = $builder->name('chart1')->element('myChart');

    expect($result)->toBeInstanceOf(Builder::class);
    expect($builder->get('element'))->toBe('myChart');
});

test('it can set labels', function () {
    $builder = new Builder();
    $result = $builder->name('chart1')->labels(['January', 'February', 'March']);

    expect($result)->toBeInstanceOf(Builder::class);
    // Use the getter method
    expect($builder->get('labels'))->toBe(['January', 'February', 'March']);
});

test('it can render chart', function () {
    $builder = new Builder();
    $result = $builder->name('chart1')->render();

    expect($result)->toBeInstanceOf(Illuminate\View\View::class);
    $expectedHtml = '<canvas id="chart1" width="" height="">';
    expect($result->render())->toContain($expectedHtml);
});

test('it can set options with nested arrays', function () {
    $builder = new Builder();
    $options = [
        'scales' => [
            'y' => [
                'min' => 0,
                'max' => 10,
                'ticks' => [
                    'stepSize' => 1,
                ],
            ],
        ],
    ];
    
    $result = $builder->name('chart1')->options($options);
    
    expect($result)->toBeInstanceOf(Builder::class);
    expect($builder->get('options.scales.y.ticks.stepSize'))->toBe(1);
    expect($builder->get('options.scales.y.min'))->toBe(0);
    expect($builder->get('options.scales.y.max'))->toBe(10);
});

test('it renders options as valid json', function () {
    $builder = new Builder();
    $options = [
        'scales' => [
            'y' => [
                'min' => 0,
                'max' => 10,
                'ticks' => [
                    'stepSize' => 1,
                ],
            ],
        ],
    ];
    
    $result = $builder->name('testChart')->options($options)->render();
    $rendered = $result->render();
    
    // Extract the options JSON from the rendered output
    preg_match('/options:\s*(\{.*?\})\s*\}\);/s', $rendered, $matches);
    expect($matches)->toHaveCount(2);
    
    $optionsJson = $matches[1];
    $decodedOptions = json_decode($optionsJson, true);
    
    expect($decodedOptions)->not()->toBeNull();
    expect($decodedOptions['scales']['y']['ticks']['stepSize'])->toBe(1);
    expect($decodedOptions['scales']['y']['min'])->toBe(0);
    expect($decodedOptions['scales']['y']['max'])->toBe(10);
});

test('it can set optionsRaw with array', function () {
    $builder = new Builder();
    $options = [
        'scales' => [
            'y' => [
                'beginAtZero' => true,
                'min' => 0,
                'max' => 10,
                'ticks' => [
                    'stepSize' => 1,
                ],
            ],
        ],
    ];
    
    $result = $builder->name('chart1')->optionsRaw($options);
    
    expect($result)->toBeInstanceOf(Builder::class);
    // optionsRaw should store the JSON string directly
    $optionsRaw = $builder->get('optionsRaw');
    expect($optionsRaw)->toBeString();
    
    $decodedOptions = json_decode($optionsRaw, true);
    expect($decodedOptions)->not()->toBeNull();
    expect($decodedOptions['scales']['y']['ticks']['stepSize'])->toBe(1);
    expect($decodedOptions['scales']['y']['beginAtZero'])->toBe(true);
});

test('it can set optionsRaw with string', function () {
    $builder = new Builder();
    $optionsString = '{"scales":{"y":{"min":0,"max":10,"ticks":{"stepSize":1}}}}';
    
    $result = $builder->name('chart1')->optionsRaw($optionsString);
    
    expect($result)->toBeInstanceOf(Builder::class);
    expect($builder->get('optionsRaw'))->toBe($optionsString);
});

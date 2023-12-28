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

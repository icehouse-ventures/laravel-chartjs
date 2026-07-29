<?php

use IcehouseVentures\LaravelChartjs\Builder;
use Illuminate\View\View;

test('it can set name', function () {
    $builder = new Builder;
    $result = $builder->name('chart1');

    expect($result)->toBeInstanceOf(Builder::class);
    // Use the builder class variable method
    expect($builder->name)->toBe('chart1');
});

test('it can set element', function () {
    $builder = new Builder;
    $result = $builder->name('chart1')->element('myChart');

    expect($result)->toBeInstanceOf(Builder::class);
    expect($builder->get('element'))->toBe('myChart');
});

test('it can set labels', function () {
    $builder = new Builder;
    $result = $builder->name('chart1')->labels(['January', 'February', 'March']);

    expect($result)->toBeInstanceOf(Builder::class);
    // Use the getter method
    expect($builder->get('labels'))->toBe(['January', 'February', 'March']);
});

test('it can render chart', function () {
    $builder = new Builder;
    $result = $builder->name('chart1')->render();

    expect($result)->toBeInstanceOf(View::class);
    $expectedHtml = '<canvas id="chart1" width="" height=""></canvas>';
    expect($result->render())->toContain($expectedHtml);
});

test('it rejects an empty chart name', function () {
    (new Builder)->name('');
})->throws(InvalidArgumentException::class);

test('it must be named before rendering', function () {
    (new Builder)->render();
})->throws(LogicException::class);

test('it validates chart types for the configured Chart.js major', function () {
    config()->set('chartjs.version', 4);

    expect(fn () => (new Builder)->name('chart1')->type('horizontalBar'))
        ->toThrow(InvalidArgumentException::class);

    config()->set('chartjs.version', 2);

    expect((new Builder)->name('chart2')->type('horizontalBar'))
        ->toBeInstanceOf(Builder::class);
});

test('it safely encodes array options', function () {
    $html = (new Builder)
        ->name('chart1')
        ->labels(['</script><script>alert(1)</script>'])
        ->optionsRaw(['title' => '</script><script>alert(1)</script>'])
        ->render()
        ->render();

    expect($html)
        ->not->toContain('</script><script>alert(1)</script>')
        ->toContain('\u003C\/script\u003E');
});

test('it renders identifiers safely in HTML and JavaScript', function () {
    $html = (new Builder)
        ->name('chart-one')
        ->render()
        ->render();

    expect($html)
        ->toContain('id="chart-one"')
        ->toContain('window[element]');
});

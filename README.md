# laravel-chartjs - A Chart.js wrapper for Laravel

Simple package to facilitate and automate the use of charts and graphs in Laravel using the [Chart.js](https://www.chartjs.org/) library. The current release supports PHP 8.2+ and Laravel 12 or 13.

## Setup

This package provides a wrapper for Chartjs that allows it to be used simply and easily inside a Laravel application. The package supports a number of installation methods depending on your needs and familiarity with JavaScript.

### 1. Installing this package
```bash
composer require icehouse-ventures/laravel-chartjs
```

Laravel package discovery registers the service provider automatically.

Publishing the config file to your own application will allow you to customise the package with several settings such as the Chartjs version to be used and the delivery method for the Chartjs files.

```bash
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --tag="config"
```

### 2. Installing Chart.js
Next, choose how Chart.js will be delivered to your application.

There are several installation options for Chartjs. By default, this package comes set to use the 'custom' self-managed delivery method (to avoid conflict with existing installations). You can also select from several other delivery methods:

## CDN
For rapid development and testing between versions, set the delivery method to `cdn` in `config/chartjs.php`. Chart.js versions 2, 3 and 4 are available by CDN. The package loads the selected date adapter, plus Numeral.js for backwards compatibility. CDN URLs are pinned to the selected major so a future Chart.js major cannot be pulled into an existing application unexpectedly.

## Publish
If you do not use JavaScript packages anywhere else in your application or are new to JavaScript development, then you may not already have the Node Package Manager, Laravel Mix or Vite set up. In that case, this package includes pre-compiled versions of Chartjs that you can use in your application. To publish the chart.js binary to your application's public folder (where JavaScript bundles are stored) you can publish the package's pre-built distribution assets.

By default, the publish method will install Chartjs version 4 using the latest version in the package. If you want to publish an older version, we have also included the latest stable Chartjs releases for version 3 and version 2. You can publish these to your public assets folder using the following commands: 

```bash
# Publish Chart.js version 4 assets
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --force --tag="assets"

# Publish Chart.js version 3 assets
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --force --tag="assets-v3"

# Publish Chart.js version 2 assets
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --force --tag="assets-v2"
```

## Binary
In some rare circumstances, such as local development without an internet connection, private applications, shared servers or where you cannot access the public folder on your server, then you may wish to have end-users directly load the binary files. This method is not recommended because it streams the contents of the files from inside your application. This delivery method will load the Chartjs files normally published to your assets folder, directly from inside your vendor folder. To use this method, set the delivery config variable to 'binary' and choose the Chartjs version you wish to use in the config file. 

## NPM (Best Practice)
The recommended method is to include Chart.js in your application's normal JavaScript bundle using npm and Vite. See the [official Chart.js installation guide](https://www.chartjs.org/docs/latest/getting-started/installation.html). The other delivery methods are useful when a JavaScript build pipeline is not available.

## Custom
If you leave the config as blank or 'custom', then the package will assume that the Chart JS JavaScript has been loaded manually. You can do this by adding a CDN to the header of your page such as:

```
<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
```

# Usage:
You can call the package Facade to easily load the service responsible for building the charts and then pass through a fluent Laravel-style interface to set your various chart settings.

```php
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

$chart = Chartjs::build()
    ->name('salesChart')
    ->type('line')
    ->labels(['January', 'February'])
    ->datasets([
        [
            'label' => 'Sales',
            'data' => [12, 19],
        ],
    ])
    ->options([]);
```

The builder needs the name of the chart, the type of chart (that can be anything that is supported by Chartjs) and the other custom configurations like labels, datasets and options.

## Responsive sizing

The canvas `width` and `height` attributes are initial drawing-buffer sizes in
pixels, not CSS percentages. For a chart that follows its container, size the
wrapper with CSS and let Chart.js handle the canvas:

```php
$chart->options([
    'responsive' => true,
    'maintainAspectRatio' => false,
]);
```

```html
<div style="height: 24rem; position: relative;">
    <x-chartjs-component :chart="$chart" />
</div>
```

In the dataset interface you can pass any configuration and options to your chart. All options available in Chartjs documentation are supported. Just write the configuration with php array notations and it works!

```php
$chart->options([
        'scales' => [
            'x' => [
                'title' => [
                    'display' => true,
                    'text' => 'X Axis Title'
                ],
            ]
        ]
    ]);
```

# Advanced Chartjs options

The basic options() method allows you to add simple key-value pair based options. Using the optionsRaw() method it's possible to add more complex nested Chartjs options in raw json format and to used nested calls to the options for plugins:

Passing raw JavaScript options to the chart:
```php
$chart->optionsRaw("{
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'X Axis Title',
                }
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Chart Title',
                font: {
                    size: 16
                }
            },
            legend: {
                display: false,
            },
        }
    }");
```

The string form of `optionsRaw()` is inserted as executable JavaScript. Only use it with application-authored values; never interpolate user input. Prefer passing an array when callbacks or other JavaScript expressions are not required.

# Examples

1 - Line Chart:
```php
// Controller CExampleController.php
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

$chart = Chartjs::build()
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
        ->datasets([
            [
                "label" => "My First dataset",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" => [65, 59, 80, 81, 56, 55, 40],
                "fill" => false,
            ],
            [
                "label" => "My Second dataset",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" => [12, 33, 44, 44, 55, 23, 40],
                "fill" => false,
            ]
        ])
        ->options([]);

return view('example', compact('chart'));

// Blade example.blade.php

<div style="width:75%;">
    <x-chartjs-component :chart="$chart" />
</div>
```


2 - Bar Chart:
```php
// Controller ExampleController.php
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

$chart = Chartjs::build()
         ->name('barChartTest')
         ->type('bar')
         ->size(['width' => 400, 'height' => 200])
         ->labels(['Label x', 'Label y'])
         ->datasets([
             [
                 "label" => "My First dataset",
                 'backgroundColor' => ['rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                 'data' => [69, 59]
             ],
             [
                 "label" => "My First dataset",
                 'backgroundColor' => ['rgba(255, 99, 132, 0.3)', 'rgba(54, 162, 235, 0.3)'],
                 'data' => [65, 12]
             ]
         ])
         ->options([
            "scales" => [
                "y" => [
                    "beginAtZero" => true
                    ]
                ]
         ]);

return view('example', compact('chart'));

// Blade example.blade.php

<div style="width:75%;">
    <x-chartjs-component :chart="$chart" />
</div>
```

3 - Pie Chart / Doughnut Chart:
```php
// Controller ExampleController.php
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

$chart = Chartjs::build()
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Label x', 'Label y'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => [69, 59]
            ]
        ])
        ->options([]);

return view('example', compact('chart'));

// Blade example.blade.php

<div style="width:75%;">
    <x-chartjs-component :chart="$chart" />
</div>
```

# Advanced Custom Views
If you need to edit the underlying Blade component (to adjust CDN logic or deeper CSS changes to the `<canvas>` element used to render the charts), you can publish the views:

```bash
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --tag="views" --force
```

You can then customise the published Blade file at `./views/vendor/laravelchartjs/chart-template.blade.php` in your application.

To revert any customisation, simply delete or rename this file from your application.

# Livewire Interactive Charts
This package supports dynamically updated charts in Livewire. The current
release and [demo repository](https://github.com/icehouse-ventures/laravel-chartjs-demo)
are tested with Livewire 4. Conventions for computed properties and public state
may differ on earlier Livewire versions.

```php
 // Inside your Livewire blade component: example-livewire-chart-demo.blade.php
<div class="main">

    <div class="chart-container">
        <x-chartjs-component :chart="$this->chart" />
    </div>

</div>
```

```php
// Inside your  Livewire php component: ExampleLivewireChartDemo.php
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

class ExampleLivewireChartDemo extends Component
{
    public $datasets;

    #[Computed]
    public function chart()
    {
        return Chartjs::build()
            ->name("UserRegistrationsChart")
            ->livewire()
            ->model("datasets")
            ->type("line");
    }

    public function render()
    {
        $this->getData();

        return view('livewire.example-livewire-chart-demo');
    }
    
    public function getData()
    {
        $data = []; // your data here
        $labels = []; // your labels here
        
        $this->datasets = [
            'datasets' => [
                [
                    "label" => "User Registrations",
                    "backgroundColor" => "rgba(38, 185, 154, 0.31)",
                    "borderColor" => "rgba(38, 185, 154, 0.7)",
                    "data" => $data
                ]
            ],
            'labels' => $labels
        ];
    }
}
```

# Legacy API
The previous builder API is retained for applications upgrading to this major. It can be accessed through `app()->chartjs`, and the chart can be rendered directly with `{!! $chart->render() !!}`.

```php
// Controller ExampleController.php

$chart = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Label x', 'Label y'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => [69, 59]
            ]
        ])
        ->options([]);

return view('example', compact('chart'));

// Blade example.blade.php

<div style="width:75%;">
    {!! $chart->render() !!}
</div>
```

# Contributing

Laravel Chart.js is community-maintained. Contributions from first-time and
returning contributors are welcome: bug reproductions, documentation fixes,
tests, accessibility improvements, and compatibility updates all help. Open an
issue or discussion for design questions, or send a focused pull request for a
well-understood change.

# Development

```bash
composer install
npm ci
npm run build
composer check
```

`composer check` runs Pint, PHPStan and the Pest test suite. The committed `dist/chart.js` bundle is built from the versions locked in `package-lock.json`.

# License
LaravelChartjs is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

# Provenance
Some of the original logic was developed by Brian Faust. The package from which this version was forked was primarily developed and maintained by Felix Costa. Icehouse Ventures adopted stewardship in 2024 and maintains the project with its community of contributors.

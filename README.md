# laravel-chartjs - A Chart.js wrapper for Laravel

Simple package to facilitate and automate the use of charts and graphs in Laravel using the [Chart.js](http://www.chartjs.org/) library.

# Setup:
This package provides a wrapper for Chartjs that allows it to be used simply and easily inside a Laravel application. The package supports a number of installation methods depending on your needs and familiarity with JavaScript.

## 1. Installing this package
```bash
composer require icehouse-ventures/laravel-chartjs
```

For older versions of Laravel (8 and below), add the Service Provider in your file config/app.php:
```php
IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider::class
```

Publishing the config file to your own application will allow you to customise the package with several settings such as the Chartjs version to be used and the delivery method for the Chartjs files.

```bash
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --tag="config"
```

## 2. Installing Chartjs
Next, you can install and add to your layouts / templates the Chartjs library that can be easily found for download at: http://www.chartjs.org

There are several installation options for Chartjs. By default, this package comes set to use the 'custom' self-managed delivery method (to avoid conflict with existing installations). You can also select from several other delivery methods:

## CDN
For rapid development and testing between versions, you can easily set the delivery method to 'CDN' in the config\chartjs.php settings, this will load the specified Chartjs files via an external content delivery network. Chartjs versions 2, 3 and 4 are available by CDN. These also load Moment.js and Numeral.js which are commonly needed for business charts.

## Publish
If you do not use JavaScript packages anywhere else in your application or are new to JavaScript development, then you may not already have the Node Package Manager, Laravel Mix or Vite set up. In that case, this package includes pre-compiled versions of Chartjs that you can use in your application. To publish the chart.js binary to your application's public folder (where JavaScript bundles are stored) you can publish the package's pre-built distribution assets.

By default, the publish method will install Chartjs version 4 using the latest version in the package. If you want to publish an older version, we have also included the latest stable Chartjs releases for version 3 and version 2. You can publish these to your public assets folder using the following commands: 

```bash
// Publish Chartjs version 4 assets
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --force --tag="assets"

// Publish Chartjs version 3 assets 
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --force --tag="assets-v3"

// Publish Chartjs version 2 assets 
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --force --tag="assets-v2"
```

## Binary
In some rare circumstances, such as local development without an internet connection, private applications, shared servers or where you cannot access the public folder on your server, then you may wish to have end-users directly load the binary files. This method is not recommended because it streams the contents of the files from inside your application. This delivery method will load the Chartjs files normally published to your assets folder, directly from inside your vendor folder. To use this method, set the delivery config variable to 'binary' and choose the Chartjs version you wish to use in the config file. 

## NPM (Best Practice)
The recommended method to install Chartjs in a web application is to include it in your normal JavaScript and/or CSS bundle pipeline using NPM, Laravel Mix or Vite. For instructions on this method of installation please visit: https://www.chartjs.org/docs/latest/getting-started/ If you do not currently have a JavaScript package manager installed, the other delivery methods are helpful until you need one.

## Custom
If you leave the config as blank or 'custom', then the package will assume that the Chart JS JavaScript has been loaded manually. You can do this by adding a CDN to the header of your page such as:

```
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
```

# Usage:
You can call the package Facade to easily load the service responsible for building the charts and then pass through a fluent Laravel-style interface to set your various chart settings.

```php
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;

$chart = Chartjs::build()
    ->name()
    ->type()
    ->labels()
    ->datasets()
    ->options();
```

The builder needs the name of the chart, the type of chart (that can be anything that is supported by Chartjs) and the other custom configurations like labels, datasets and options.

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

The basic options() method allows you to add simple key-value pair based options. Using the optionsRaw() method it's possible to add more complex nested Chartjs options in raw JavaScript format and to use JavaScript functions for callbacks:

## Basic Raw Options

Passing string format raw options to the chart like a JavaScript object:
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

## Number Formatting with JavaScript Functions

For advanced number formatting (like currency display), you can use JavaScript functions in your optionsRaw:

```php
$chart->optionsRaw('{
    responsive: true,
    plugins: {
        tooltip: {
            callbacks: {
                label: function(context) {
                    let label = context.dataset.label || "";
                    if (label) {
                        label += ": ";
                    }
                    if (context.parsed.y !== null) {
                        label += "R$ " + context.parsed.y.toLocaleString("pt-BR", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                    return label;
                }
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            ticks: {
                callback: function(value, index, values) {
                    return "R$ " + value.toLocaleString("pt-BR", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            }
        }
    }
}');
```

For US dollar formatting:
```php
$chart->optionsRaw('{
    responsive: true,
    plugins: {
        tooltip: {
            callbacks: {
                label: function(context) {
                    let label = context.dataset.label || "";
                    if (label) {
                        label += ": ";
                    }
                    if (context.parsed.y !== null) {
                        label += "$" + context.parsed.y.toLocaleString("en-US", {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                    return label;
                }
            }
        }
    },
    scales: {
        y: {
            ticks: {
                callback: function(value, index, values) {
                    return "$" + value.toLocaleString("en-US", {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                }
            }
        }
    }
}');
```

## Troubleshooting optionsRaw

If your number formatting isn't working:

1. **Check JavaScript syntax**: Ensure your JavaScript object syntax is valid. You can use either quoted (`"responsive": true`) or unquoted (`responsive: true`) property names.

2. **Verify function placement**: Callback functions should be placed in the correct Chart.js option paths:
   - Tooltip formatting: `plugins.tooltip.callbacks.label`
   - Axis tick formatting: `scales.y.ticks.callback` (or `scales.x.ticks.callback`)

3. **Test with browser console**: Open your browser's developer console to check for JavaScript errors that might prevent the functions from executing.

4. **Check Chart.js version compatibility**: Ensure your callback function syntax matches your Chart.js version. This package supports Chart.js v2, v3, and v4.

5. **Validate locale support**: Make sure the locale you're using (like "pt-BR") is supported by the browser's `toLocaleString()` method.

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
This package has support for dynamic live updating charts in Livewire. See the [demo repo](https://github.com/icehouse-ventures/laravel-chartjs-demo) Note that the conventions for passing props to Livewire (such as declaring public properties or adding attributes to a function may vary for your Livewire version. 

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
        ]
    }
}
```

# Legacy Support
This package also supports older versions of Laravel and Chartjs. The previous syntax for building charts is still supported and can be accessed via the `app()->chartjs` method. The previous blade rendering syntax is also still supported, and can be accessed via the `{{ $chart->render() }}` directive. The legacy syntax is particularly useful for migrating to this package from the previous versions of this package.

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

# Issues
This README, as well as the package, is in development, but will be constantly updated, and we will keep you informed. Any questions or suggestions preferably open a discussion first before creating an issue.

# License
LaravelChartjs is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

# Provenance
Some of the original logic for this package was originally developed by Brian Faust. The main package from which this current version of the package is forked was primarily developed and maintained by Felix Costa. In 2024, the package was adopted by Icehouse Ventures which is an early-stage venture capital firm based in New Zealand. We use Chartjs heavily in our Laravel applications and want to give back to the Laravel community by making Chartjs fast and easy to implement across all major versions and to streamline the upgrade path.

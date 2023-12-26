# laravel-chartjs - A Chart.js wrapper for Laravel

Simple package to facilitate and automate the use of charts in Laravel 
using the [Chart.js](http://www.chartjs.org/) library.

# Setup:
```
composer require icehouse-ventures/laravel-chartjs
```

For Laravel 8 (and below), add the Service Provider in your file config/app.php:
```php
IcehouseVentures\LaravelChartJs\Providers\ChartJsServiceProvider::class
```

Publishing the config file to your own application allows you to customise the package with several settings such as the Chartjs version to be used, the installation and delivery method for the Chartjs files.

```
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartJs\Providers\ChartJsServiceProvider" --tag="config"
```

Finally, you can install and add to your layouts / templates the Chartjs library that can be easily
found for download at: http://www.chartjs.org

There are several installation options for Chartjs. By default, the package comes set to use the custom / self-managed delivery method (to avoid conflict with existing installations). For rapid development and testing between versions, you can easily set the delivery method to 'CDN' in the config\chart-js.php settings, this will load the specified Chartjs files via an external content delivery network.

# Usage:

You can request to Service Container the service responsible for building the charts
and passing through fluent interface the chart settings.

```php
$service = app()->chartjs
    ->name()
    ->type()
    ->size()
    ->labels()
    ->datasets()
    ->options();
```

The builder needs the name of the chart, the type of chart that can be anything that is supported by Chartjs and the other custom configurations like labels, datasets, size and options.

In the dataset interface you can pass any configuration and option to your chart.
All options available in Chartjs documentation are supported.
Just write the configuration with php array notations and it works!

# Advanced Chartjs options

The basic options() method allows you to add simple key-value pair based options, but it is not possible to generate nested options such as those used to do complex formatting on scales (Chartjs v3+ example):

```php
    options: {
        scales: {
            x: {
                type: 'time',
                time: {
                    displayFormats: {
                        quarter: 'MMM YYYY'
                    }
                }
            }
        }
    }
```

Using the optionsRaw() method it's possible to add nested Chartjs options in raw format (Chartjs v2 example):

Passing string format like a json
```php
        $chart->optionsRaw("{
            legend: {
                display:false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display:false
                    }  
                }]
            }
        }");
```

Or, if you prefer, you can pass a php array format and the package will convert it to the JSON format used by Chartjs:

```php
$chart->optionsRaw([
    'legend' => [
        'display' => true,
        'labels' => [
            'fontColor' => '#000'
        ]
    ],
    'scales' => [
        'xAxes' => [
            [
                'stacked' => true,
                'gridLines' => [
                    'display' => true
                ]
            ]
        ]
    ]
]);
```


# Examples

1 - Line Chart / Radar Chart:
```php
// ExampleController.php

$chartjs = app()->chartjs
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
                'data' => [65, 59, 80, 81, 56, 55, 40],
            ],
            [
                "label" => "My Second dataset",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => [12, 33, 44, 44, 55, 23, 40],
            ]
        ])
        ->options([]);

return view('example', compact('chartjs'));


 // example.blade.php

<div style="width:75%;">
    {!! $chartjs->render() !!}
</div>
```


2 - Bar Chart:
```php
// ExampleController.php

$chartjs = app()->chartjs
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
         ->options([]);

return view('example', compact('chartjs'));


 // example.blade.php

<div style="width:75%;">
    {!! $chartjs->render() !!}
</div>
```


3 - Pie Chart / Doughnut Chart:
```php
// ExampleController.php

$chartjs = app()->chartjs
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

return view('example', compact('chartjs'));


 // example.blade.php

<div style="width:75%;">
    {!! $chartjs->render() !!}
</div>
```

# Issues
This README, as well as the package, is in development, but will be constantly updated and we will keep you informed. Any questions or suggestions preferably open a discussion first before creating an issue.

# License
LaravelChartJs is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

# Provenance
Some of the original logic for this package was originally developed by Brian Faust. The main package from which this current version of the package is forked was primarily developed and maintained by Felix Costa.
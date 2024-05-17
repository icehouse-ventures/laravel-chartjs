# laravel-chartjs - A Chart.js wrapper for Laravel

Simple package to facilitate and automate the use of charts in Laravel 
using the [Chart.js](http://www.chartjs.org/) library.

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
If you do not use JavaScript packages anywhere else in your application or are new to JavaScript development then you may not already have the Node Package Manager, Laravel Mix or Vite set up. In that case, this package includes pre-compiled versions of Chartjs that you can use in your application. To publish the chart.js binary to your application's public folder (where JavaScript bundles are stored) you can publish the package's pre-built distribution assets.

By default, the publish method will install Chartjs version 4 using the latest binary in the package. If you want to publish an older version, we have also included the latest stable Chartjs releases for version 3 and version 2. You can publish these to your public assets folder using the following commands: 

```bash
// Publish Chartjs version 4 assets
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --force --tag="assets"

// Publish Chartjs version 3 assets 
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --force --tag="assets-v3

// Publish Chartjs version 2 assets 
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --force --tag="assets-v2"
```

## Binary
In some rare circumstances such as local development without an internet connection, private applications, shared servers or where you cannot access the public folder on your server, then you may wish to have end-users directly load the binary files. This method is not recommended because it streams the contents of the files from inside your application. This delivery method will load the Chartjs files normally published to your assets folder directly from inside your vendor folder. To use this method, set the delivery config variable to 'binary' and choose the Chartjs version you wish to use in the config file. 

## NPM (Recommended)
The recommended method to install Chartjs in a web application is to include it in your normal JavaScript and/or CSS bundle pipeline using NPM, Laravel Mix or Vite. For instructions on this method of installation please visit: https://www.chartjs.org/docs/latest/getting-started/

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

In the dataset interface you can pass any configuration and option to your chart.All options available in Chartjs documentation are supported.
Just write the configuration with php array notations and it works!

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

The basic options() method allows you to add simple key-value pair based options. Using the optionsRaw() method it's possible to add more complex nested Chartjs options in raw json format and call the options for plugins:

Passing string format like a json
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

# Examples

1 - Line Chart:
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
         ->options([
            "scales" => [
                "y" => [
                    "beginAtZero" => true
                    ]
                ]
         ]);

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

# Advanced custom views
If you want to customise the appearance of all charts in your application (for example tweaking the mobile responsive css settings), then it is recommended to create a standard blade component and insert the {!! $chartjs->render() !!} reference inside your custom component (be sure to pass down the variable from your controller to your component). If for some reason you really need to edit the core blade template (for example to adjust the CDN logic or make deeper CSS changes to the canvas styling), then you can publish the blade template to your resources\vendor\laravelchartjs folder and edit the custom-chart-template.blade.php 

To activate the custom blade template changes, you can set the config option 'custom_view' to true.

```bash
php artisan vendor:publish --provider="IcehouseVentures\LaravelChartjs\Providers\ChartjsServiceProvider" --tag="views" --force
```

# Livewire Support
This package has prototype support for live updating on Livewire. See the [demo repo](https://github.com/icehouse-ventures/laravel-chartjs-demo)

```php
 // In your parent Livewire blade component 
 <div class="chart-container">
    {!! $this->chart->render() !!}
 </div>
```

```php
// In your parent Livewire component
class UsersChart extends Component
{
    public $datasets;

    #[Computed]
    public function chart()
    {
        return app()
            ->chartjs
            ->name("UserRegistrationsChart")
            ->livewire()
            ->model("datasets")
            ->type("line");
    }

    public function render()
    {
        $this->getData();

        return view('livewire.users-chart');
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

# Issues
This README, as well as the package, is in development, but will be constantly updated, and we will keep you informed. Any questions or suggestions preferably open a discussion first before creating an issue.

# License
LaravelChartjs is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

# Provenance
Some of the original logic for this package was originally developed by Brian Faust. The main package from which this current version of the package is forked was primarily developed and maintained by Felix Costa. In 2024 the package was adopted by Icehouse Ventures which is an early-stage venture capital firm based in New Zealand. We use Chartjs heavily in our Laravel applications and want to give back to the Laravel community by making Chartjs fast and easy to implement across all major versions and to streamline the upgrade path.
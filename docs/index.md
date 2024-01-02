## Laravel Chart.js User Guide

Welcome to the Laravel Chartjs User Chart Guide. This page will walk you through the process of creating a chart in a Laravel application using the Laravel Chartjs package, with data from a User model.

### Prerequisites

Before you begin, ensure you have the following:

- Laravel application installed and set up
- LaravelChartjs package installed
- User model with relevant data (e.g., registrations over time)

### Installation

If you haven't already installed LaravelChartjs, you can do so via composer:

```bash
composer require icehouseventures/laravel-chartjs
```

### Configuration

Publish the configuration file to customize the package settings:

```bash
php artisan vendor:publish --provider="IcehouseVentures\\LaravelChartjs\\ServiceProvider"
```

### Creating a Chart

In this example, we'll create a line chart displaying user registrations per month.

#### 1. Prepare Data

First, we need to prepare the data for the chart. In your `UserController`, add the following method to aggregate user registrations. Next, use the data to create the chart:

```php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Collection;

class UserController extends \App\Http\Controllers\Controller
{

    public function index()
    {
    

    $start = User::min("created_at");
    $end = now();
    $period = new \Carbon\CarbonPeriod($start, "1 month", $end);

    $usersPerMonth = collect($period)->map(function ($date) {
    $endDate = $date->copy()->endOfMonth();

    return [
        "count" => User::where("created_at", "<=", $endDate)->count(),
        "month" => $endDate->format("Y-m-d")
    ];
    });

    $data = $usersPerMonth->pluck("count")->toArray();
    $labels = $usersPerMonth->pluck("month")->toArray();

    $chart = app()
    ->chartjs->name("UserRegistrationsChart")
    ->type("line")
    ->size(["width" => 400, "height" => 200])
    ->labels($labels)
    ->datasets([
        [
        "label" => "User Registrations",
        "backgroundColor" => "rgba(38, 185, 154, 0.31)",
        "borderColor" => "rgba(38, 185, 154, 0.7)",
        "data" => $data
        ]
    ])
    ->options([]);

    return view("user.chart", compact("chart"));

    }
}
```

#### 3. Display Chart in View

Create a Blade file named `chart.blade.php` in the `resources/views/user` directory and add the following code to render the chart:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Registrations Chart</title>
</head>
<body>
    <h1>Monthly User Registrations</h1>
    <div style="width:75%;">
        {!! $chartjs->render() !!}
    </div>
</body>
</html>
```

#### 4. Route Configuration

Make sure to add a route to display the chart:

```php
Route::get('/user/chart', 'UserController@showChart');
```

### Conclusion

You've now created a line chart displaying user registrations per month using the LaravelChartjs package. Visit `/user-chart` in your Laravel application to view the chart.

For more advanced usage and customization options, refer to the official Chart.js documentation.
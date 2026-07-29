<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chartjs Version
    |--------------------------------------------------------------------------
    |
    | Version 4 is the current supported Chart.js major. Versions 2 and 3
    | remain available to support migrations from older applications.
    |
    | Available choices are '2', '3' and '4'
    |
    */

    'version' => 4,

    /*
    |--------------------------------------------------------------------------
    | Installation and Delivery Method
    |--------------------------------------------------------------------------
    |
    | There are several ways to install Chartjs into a Laravel application,
    | using a Content Delivery Network can be a good starting point for
    | local development and small sites. We also include binary files and a
    | script to publish the assets. We recommend delivery via a JavaScript NPM
    | build pipeline such as Laravel Mix, Yarn, Webpack or Vite. The custom
    | option is self-managed and designed to not interfere with your
    | existing delivery method for example when migrating
    | from another package.
    |
    | Available choices are 'CDN', 'publish', 'binary', 'npm' and 'custom'.
    |
    */

    'delivery' => 'custom',

    /*
    |--------------------------------------------------------------------------
    | Date Plugin
    |--------------------------------------------------------------------------
    |
    | JavaScript packages like Chartjs often need an add-on time & date package
    | to enable them to parse, compare, and format dates (similar to how we
    | use Carbon in Laravel). Chart.js works with the three most popular date
    | packages. To assist in migrating between packages, the CDN delivery
    | method allows you to swap between date packages. Make sure to check
    | the syntax of the callbacks you are using and the capitalisation
    | of the date formats as they are different between packages.
    |
    | Available choices are 'moment', 'luxon', 'date-fns' and 'none'.
    |
    */

    'date_adapter' => 'luxon',

    /*
    |--------------------------------------------------------------------------
    | Custom Chart Type Plugins
    |--------------------------------------------------------------------------
    |
    | You can add plugins to Chart.js for various custom chart types
    | by adding the name of the chart type and the URL to the plugin.
    | This is useful for adding custom chart types to the package
    | without having to modify the package itself.
    |
    | Available choices are type labels and urls to CDNs. such as:
    | 'treemap' => 'https://cdn.jsdelivr.net/npm/chartjs-chart-treemap@2.3.1/dist/chartjs-chart-treemap.min.js'
    |
    */

    'custom_chart_types' => [],

];

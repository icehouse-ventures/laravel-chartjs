<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chartjs Version
    |--------------------------------------------------------------------------
    |
    | We default to version 2 for easy transition from the existing
    | Laravel Chartjs packages. Each version has breaking changes
    | which are worth investigating before migrating.
    |
    | Available choices are '2', '3' and '4'
    |
    */

    'version' => 2,

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
    | Plugins Enabled
    |--------------------------------------------------------------------------
    |
    | Plugins are an important part of extending the Chartjs core functionality
    | we include some common plugins in the pre-configured CDN and binary 
    | build setup. These packages can be controlled below
    |
    | Available choices are true and false.
    |
    */

    'plugins' => true,

    /*
    |--------------------------------------------------------------------------
    | Custom View Option
    |--------------------------------------------------------------------------
    |
    | The custom view option allows you to specify whether the package should
    | use a custom blade view for rendering charts. If set to 'true', the
    | package will look for a view named 'custom-chart-template.blade.php'
    | in the /vendor folder of your view resources. If set to 'false' or
    | not specified, the default view 'chart-template.blade.php' built
    | into the package will be used. You can publish the default
    | view to your resources folder using an artisan command.
    |
    | Available choices are true or false.
    |
    */

    'custom_view' => false,

];


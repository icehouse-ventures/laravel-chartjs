<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ChartJS Version
    |--------------------------------------------------------------------------
    |
    | We default to version 2 for easy transition from the existing
    | Laravel ChartJS packages. Each version has breaking changes
    | which are worth investigating before migrating.
    | Available choices are 2, 3 and 4
    |
    */

    'version' => 2,

    /*
    |--------------------------------------------------------------------------
    | Installation and Delivery Method
    |--------------------------------------------------------------------------
    |
    | There are several ways to install ChartJS into a Laravel application
    | using a Content Delivery Network can be a good starting point for
    | local development and small sites. We also include a binary for
    | some versions and recommended setup via a JavaScript NPM build
    | pipeline such as Laravel Mix, Yarn, Webpack or Vite.
    | Available choices are CDN, binary, npm and custom.
    |
    */

    'delivery' => 'custom',

    /*
    |--------------------------------------------------------------------------
    | Plugins
    |--------------------------------------------------------------------------
    |
    | Plugins are an important part of extending the ChartJS core functionality
    | we include some common plugins in the pre-configured CDN and binary 
    | build setup. These packages can be controlled below
    | Available choices are enabled and disabled.
    |
    */

    'plugins' => 'enabled',


];


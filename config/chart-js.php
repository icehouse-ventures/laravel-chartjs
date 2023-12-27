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
    |
    | Available choices are 2, 3 and 4
    |
    */

    'version' => 2,

    /*
    |--------------------------------------------------------------------------
    | Installation and Delivery Method
    |--------------------------------------------------------------------------
    |
    | There are several ways to install ChartJS into a Laravel application,
    | using a Content Delivery Network can be a good starting point for
    | local development and small sites. We also include binary files and a
    | script to publish the assets. We recommend delivery via a JavaScript NPM
    | build pipeline such as Laravel Mix, Yarn, Webpack or Vite. The custom
    | option is self-managed and designed to not interfere with your
    | existing delivery method for example when migrating 
    | from another package.
    |
    | Available choices are CDN, publish, binary, npm and custom.
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


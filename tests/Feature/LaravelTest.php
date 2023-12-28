<?php

it('can create and load Laravel app', function () {
    // Create the Laravel application
    $app = new \Illuminate\Foundation\Application();

    // Perform assertions to check if the app is loaded
    expect($app)->toBeInstanceOf(\Illuminate\Foundation\Application::class);
    expect(\Illuminate\Support\Facades\App::environment())->toBe('testing');

});

<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;

it('can create and load Laravel app', function () {
    expect(app())->toBeInstanceOf(Application::class);
    expect(App::environment())->toBe('testing');
});

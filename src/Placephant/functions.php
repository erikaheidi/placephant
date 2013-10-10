<?php

namespace Placephant;

use Flint\Application;
use Placephant\Provider\PlacephantServiceProvider;

/**
 * Create application
 *
 * @return Application
 */
function create_application()
{
    $app = new Application(__DIR__ . '/../../', true);
    $app->register(new PlacephantServiceProvider);

    return $app;
}

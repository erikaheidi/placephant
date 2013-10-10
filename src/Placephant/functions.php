<?php

namespace Placephant;

use Flint\Application;
use Placephant\Provider\PlacephantServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;

/**
 * Create application
 *
 * @return Application
 */
function create_application()
{
    $app = new Application(__DIR__ . '/../../', false, array(
        'config.cache_dir' => __DIR__ . '/../../app/cache/config',
    ));
    $app->register(new PlacephantServiceProvider);
    $app->register(new HttpCacheServiceProvider);
    $app->boot();

    return $app['http_cache'];
}

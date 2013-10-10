<?php

namespace Placephant\Provider;

use Silex\Application;
use Placephant\ResourceHelper;

/**
 * @package Placephant
 */
class PlacephantServiceProvider implements \Silex\ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(Application $app)
    {
        $app['resources'] = $app->share(function ($app) {
            return new ResourceHelper($app['config']['resources']);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
        $app->configure($app['root_dir'] . '/app/config/config.yml');
    }
}

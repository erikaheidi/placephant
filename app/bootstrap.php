<?php
require_once __DIR__.'/../vendor/autoload.php';

use Flint\Application;

$resource_dir = __DIR__ . "/../src/resources";

$app = new Application(__DIR__, true);
$app['debug'] = false;
#$app->configure('config.yml');

/* definitions */
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app['resources'] = $app->share(function() use($resource_dir) {
    return new Helper\Resource();
});

return $app;

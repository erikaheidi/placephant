<?php
require_once __DIR__.'/../vendor/autoload.php';

//$app = new Silex\Application();

use Flint\Application;


$resource_dir = __DIR__ . "/../src/resources";

$app = new Application(__DIR__, true);
#$app->configure('config.yml');

/* definitions */

$app['resources'] = $app->share(function() use($resource_dir) {
    return new Helper\Resource();
});

return $app;

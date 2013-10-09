<?php

require __DIR__ . "/bootstrap.php";

use Symfony\Component\HttpFoundation\Response;

$app->get('/{width}/{height}/{bw}', function($width, $height, $bw) use ($app) {

    $resource = $app['resources']->getRandom();

    if (!$height)
        $height = $width;

    $imanee = (new \Imanee\Imanee($resource))
        ->thumbnail(abs($width), abs($height), true);

    if ($bw) {
       /* apply black and white filter */
    }

    return new Response($imanee->output(), 200, array('Content-Type' => 'image/jpg'));

})
->value("height", 0)
->value("bw", false);

$app->get('/', function() use ($app) {
    return $app['twig']->render('index.twig.html', array ("config" => $app['config']));
});

$app->run();
<?php

require __DIR__ . "/bootstrap.php";

use Symfony\Component\HttpFoundation\Response;

$app->get('/{width}/{height}/{bw}', function($width, $height, $bw) use ($app) {

    $resource = $app['resources']->getRandom();

    /*
    $response = new Response();
    $response->headers->set('Content-Type', 'image/jpg');
    $response->headers->set('Content-length', filesize($resource));
    $response->headers->set('Connection', 'Keep-Alive');
    $response->headers->set('Accept-Ranges','bytes');
    $response->send();
    */
    $imanee = (new \Imanee\Imanee($resource))
        ->thumbnail($width, $height, true);

    if ($bw) {
       /* apply black and white filter */
    }

    return new Response($imanee->output(), 200, array('Content-Type' => 'image/jpg'));

})
->value("bw", false);

$app->get('/', function() use ($app) {
    return $app['twig']->render('index.twig.html');
});

$app->run();
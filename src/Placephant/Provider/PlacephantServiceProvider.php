<?php

namespace Placephant\Provider;

use Imanee\Imanee;
use Silex\Application;
use Placephant\ResourceHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        $app->error(
            function (\Exception $e) use ($app) {
                if ($e instanceof NotFoundHttpException) {
                    return $this->getErrorImage(404, $app);
                }

                $code = ($e instanceof HttpException) ? $e->getStatusCode() : 500;
                return $this->getErrorImage($code, $app);
            }
        );
    }

    /**
     * {@inheritDoc}
     */
    public function boot(Application $app)
    {
        $app->configure($app['root_dir'] . '/app/config/config.yml');
    }

    private function getErrorImage($code, $app)
    {
        $imanee = new Imanee($app['root_dir'] . '/src/Placephant/Resources/images/error'.$code.'.jpg');
        $response = Response::create($imanee->thumbnail(50, 50, true)->output(), 200, array(
            'Content-Type' => 'image/jpg',
        ));
        $response->setPublic();
        $response->setSharedMaxAge(1);

        return $response;
    }
}

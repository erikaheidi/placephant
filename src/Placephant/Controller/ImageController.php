<?php

namespace Placephant\Controller;

use Imanee\Imanee;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @package Placephant
 */
class ImageController extends \Flint\Controller\Controller
{
    /**
     * @param Request $request
     * @param integer $width
     * @param integer $height
     * @param boolean $bw
     * @return Response
     */
    public function showAction(Request $request, $width, $height = 0, $bw = false)
    {
        $config = $this->get('config');
        $resource = $this->get('resources')->getRandom();

        $height = min(abs($height ?: $width), $config['max_height']);
        $width = min(abs($width), $config['max_width']);

        $imanee = (new Imanee($resource))
            ->thumbnail($width, $height, true);

        if ($bw) {
           /* apply black and white filter */
        }

        $response = Response::create($imanee->output(), 200, array(
            'Content-Type' => 'image/jpg',
        ));
        $response->setPublic();
        $response->setSharedMaxAge(1800); // 30 minutes

        return $response;
    }
}

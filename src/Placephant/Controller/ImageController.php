<?php

namespace Placephant\Controller;

use Imanee\Drawer;
use Imanee\Exception\FilterNotFoundException;
use Imanee\Imanee;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package Placephant
 */
class ImageController extends \Flint\Controller\Controller
{
    /**
     * Default mode, accepts a filter as request parameter
     *
     * @param Request $request
     * @param integer $width
     * @param integer $height
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request, $width, $height = 0)
    {
        $imanee = $this->getImageResource($width, $height);

        if ($request->query->has('filter')) {
            try {
                $imanee->applyFilter('filter_' . $request->query->get('filter'));
            } catch (FilterNotFoundException $e) {};
        }

        return $this->outputImage($imanee);
    }

    /**
     * Convenient route to get black and white placeholders.
     *
     * @param integer $width
     * @param integer $height
     * @return Response
     */
    public function bwShowAction($width, $height = 0)
    {
        $imanee = $this->getImageResource($width, $height);

        $imanee->applyFilter('filter_bw');

        return $this->outputImage($imanee);
    }

    /**
     * Verbose mode.
     *
     * @param integer $width
     * @param integer $height
     * @return Response
     */
    public function verboseShowAction($width, $height = 0)
    {
        $imanee = $this->getImageResource($width, $height);
        $imanee->applyFilter('filter_modulate', ['saturation' => 0, 'brightness' => 100]);

        $text = $imanee->getWidth() . 'x' . $imanee->getHeight();

        $drawer = new Drawer();
        $drawer->setFontColor('white');
        $imanee->setDrawer($drawer);

        $imanee->placeText($text, IMANEE::IM_POS_MID_CENTER, $imanee->getWidth() * 0.8);

        return $this->outputImage($imanee);
    }

    private function getImageResource($width, $height = 0)
    {
        $resource = $this->get('resources')->getRandom();
        list($width, $height) = $this->getSize($width, $height);

        return (new Imanee($resource))->thumbnail($width, $height, true);
    }

    private function getSize($width, $height = 0)
    {
        $config = $this->get('config');

        $height = min(abs($height ?: $width), $config['max_height']);
        $width = min(abs($width), $config['max_width']);

        return [$width, $height];
    }

    private function outputImage(Imanee $imanee)
    {
        $response = Response::create($imanee->output(), 200, array(
            'Content-Type' => 'image/jpg',
        ));
        $response->setPublic();
        $response->setSharedMaxAge(1800); // 30 minutes

        return $response;
    }
}

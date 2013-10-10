<?php

namespace Placephant\Controller;

use Imanee\Imanee;

/**
 * @package Placephant
 */
class ImageController extends \Flint\Controller\Controller
{
    /**
     * @param integer $width
     * @param integer $height
     * @param boolean $bw
     * @return Response
     */
    public function showAction($width, $height = 0, $bw = false)
    {
        $resource = $this->get('resources')->getRandom();
        $height = $height ?: $width;


        $imanee = (new Imanee($resource))
            ->thumbnail(abs($width), abs($height), true);

        if ($bw) {
           /* apply black and white filter */
        }

        return $this->text($imanee->output(), 200, array(
            'Content-Type' => 'image/jpg')
        );
    }
}

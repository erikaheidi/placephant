<?php

namespace Placephant\Controller;

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
     * @param Request $request
     * @param integer $width
     * @param integer $height
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request, $width, $height = 0)
    {
        $config = $this->get('config');
        $resource = $this->get('resources')->getRandom();

        $height = min(abs($height ?: $width), $config['max_height']);
        $width = min(abs($width), $config['max_width']);

        $imanee = (new Imanee($resource))
            ->thumbnail($width, $height, true);

        if ($request->query->has('filter')) {
            try {
                $imanee->applyFilter('filter_' . $request->query->get('filter'));
            } catch (FilterNotFoundException $e) {};
        }

        $response = Response::create($imanee->output(), 200, array(
            'Content-Type' => 'image/jpg',
        ));
        $response->setPublic();
        $response->setSharedMaxAge(1800); // 30 minutes

        return $response;
    }
}

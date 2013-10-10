<?php

namespace Placephant\Controller;

/**
 * @package Placephant
 */
class DefaultController extends \Flint\Controller\Controller
{
    /**
     * @return string
     */
    public function indexAction()
    {
        return $this->render('Default/index.html.twig', array(
            'config' => $this->get('config'),
        ));
    }
}

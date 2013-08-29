<?php

namespace SM\Bundle\AclBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * default controller
 */
class DefaultController extends Controller
{
    /**
     * index action
     *
     * @param type $name
     *
     * @return type
     */
    public function indexAction($name)
    {
        return $this->render('SMAclBundle:Default:index.html.twig', array('name' => $name));
    }
}

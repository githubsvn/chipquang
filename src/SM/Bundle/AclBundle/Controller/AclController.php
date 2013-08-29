<?php

namespace SM\Bundle\AclBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * acl controller
 */
class AclController extends Controller
{
    /**
     * @param type $name name
     *
     * @return type
     */
    public function indexAction($name = 'test')
    {
        $container = new ContainerBuilder();
        $adminOrm = $this->container->get('sm.admin.pool');
        var_dump($adminOrm);
        die;

        return $this->render('SMAclBundle:Acl:index.html.twig', array('name' => $name));
    }

}

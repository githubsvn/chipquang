<?php

namespace SM\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * the default controller
 */
class DefaultController extends Controller
{

    /**
     * index action
     *
     * @return type
     */
    public function indexAction()
    {
        $configs = $this->container->getParameter('sm_admin');
        $dashboardItems = $configs['dashboard'];
        $groups = $this->assignGroups($dashboardItems);
        return $this->render('SMAdminBundle:Default:index.html.twig', array('groups' => $groups));
    }

    /**
     * menu action
     *
     * @return type
     */
    public function menuAction()
    {
        $configs = $this->container->getParameter('sm_admin');
        $dashboardItems = $configs['dashboard'];
        $groups = $this->assignGroups($dashboardItems);

        return $this->render('SMAdminBundle:Default:menu.html.twig', array('groups' => $groups));
    }

    /**
     * assignGroup action
     *
     * @param type $items
     *
     * @return type
     */
    private function assignGroups($items)
    {
        $groups = array();
        if (is_array($items)) {
            foreach ($items as $item) {
                if (key_exists($item['group'], $groups)) {
                    $groups[$item['group']][] = $item;
                } else {
                    $groups[$item['group']] = array($item);
                }
            }
        }

        return $groups;
    }

}

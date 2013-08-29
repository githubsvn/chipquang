<?php

namespace SM\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use SM\Bundle\AdminBundle\Entity\Menu;
use SM\Bundle\AdminBundle\Entity\MenuLanguage;
use SM\Bundle\AdminBundle\Form\MenuType;
use SM\Bundle\AdminBundle\Form\MenuLanguageType;

/**
 * Menu controller.
 *
 */
class MenuController extends Controller
{
    /**
     *
     * @param type $page
     * @param type $lang
     * @return type
     */
    public function indexAction($page, $lang) {
        if ($this->getRequest()->isMethod('POST')) {
            $_SESSION['position'] = $this->getRequest()->request->get('position', '0');
        }

        $pos = isset($_SESSION['position']) ? $_SESSION['position'] : '0';

        //get list language
        $langList = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->findAll();

        if (is_null($lang)) {
            foreach ($langList as $langData) {
                $isDefault = $langData->getIsDefault();
                if ($isDefault == 1) {
                    $lang = $langData->getId();
                    break;
                }
            }
        }

        $currentLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->find($lang);

        $criteria = array();
        $criteria[] = array('op' => '>', 'fieldName' => 'lft', 'fieldValue' => '1');
        if (!empty($pos)) {
            $criteria[] = array('op' => '=', 'fieldName' => 'position', 'fieldValue' => $pos);
        }
        
        $total = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Menu")
                ->getTotal($criteria);

        $perPage = $this->container->getParameter('per_item_page');
        $lastPage = ceil($total / $perPage);
        $previousPage = $page > 1 ? $page - 1 : 1;
        $nextPage = $page < $lastPage ? $page + 1 : $lastPage;

        $this->container->getParameter('per_item_page');
        $mnuPosTop = $this->container->getParameter('menu_position_top');
        $mnuPosLeft = $this->container->getParameter('menu_position_left');
        $mnuPosRight = $this->container->getParameter('menu_position_right');
        $mnuPosBottom = $this->container->getParameter('menu_position_bottom');

        $entities = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Menu")
                ->getList($perPage, ($page - 1) * $perPage, $criteria, array('lft' => 'ASC'));
        foreach ($entities as $theCat) {
            $theCat->setLanguage($currentLanguage);
            $position = $theCat->getPosition();
            switch ($position) {
                case $mnuPosTop:
                    $theCat->setPosition('Top');
                    break;
                case $mnuPosLeft:
                    $theCat->setPosition('Left');
                    break;
                case $mnuPosRight:
                    $theCat->setPosition('Right');
                    break;
                case $mnuPosBottom:
                    $theCat->setPosition('Bottom');
                    break;
            }
        }

        $optPos = $this->getDoctrine()
                            ->getRepository("SMAdminBundle:Menu")
                            ->buildMenuPosition();
        return $this->render('SMAdminBundle:Menu:index.html.twig', array(
            'entities' => $entities,
            'lastPage' => $lastPage,
            'previousPage' => $previousPage,
            'currentPage' => $page,
            'nextPage' => $nextPage,
            'total' => $total,
            'lang' => intval($lang),
            'langList' => $langList,
            'optPosition' => $optPos,
            'position' => $pos
        ));
    }

    /**
     * Finds and displays a CompanyType entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SMAdminBundle:Menu')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CompanyType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:Menu:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to create a new CompanyType entity.
     *
     */
    public function newAction() {
        $entity = new Menu();
        //get list language
        $repLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");
        //Get list language
        $langList = $repLanguage->getList();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                $catLanguage = new MenuLanguage();
                $catLanguage->setLanguage($language);
                $catLanguage->setMenu($entity);

                $entity->addMenuLanguage($catLanguage);

                if ($language->getIsDefault()) {
                    $defaultLanguage = $language;
                }
            }
        }

        if (!$this->getRequest()->isMethod('POST')) {
            // set referrer redirect
            $session = $this->getRequest()->getSession();
            $session->set('referrer', $this->getRequest()->server->get('HTTP_REFERER'));
        }

        $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
        $mnuTypeText = $container->getParameter('menu_type_text');
        $mnuTypeLink = $container->getParameter('menu_type_link');

        $form = $this->createForm(new MenuType(), $entity);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                //Set Url for menu
                $param = $entity->getParam();
                $type = $entity->getType();
                if ($type != $mnuTypeLink) {
                    $url = $this->buildUrlForMenu($type, $param);
                    $entity->setUrl($url);
                }

                //Set created and updated user
                $currUser = $this->get('security.context')->getToken()->getUser();
                $entity->setCreated($currUser);
                $entity->setUpdated($currUser);

                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($entity);
                foreach ($entity->getMenuLanguages() as $catLanguage) {
                    $name = $catLanguage->getName();
                    if (empty($name)) {
                        $entity->removeMenuLanguage($catLanguage);
                        $entityManager->remove($catLanguage);
                    }
                }

                $entityManager->flush();

                $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The operation is success'));

                $referrer = $this->getRequest()->getSession()->get('referrer');

                if (!$referrer) {

                    return $this->redirect(
                        $this->generateUrl('admin_menu')
                    );
                } else {

                    return $this->redirect($referrer);
                }
            } else {
                $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_error', $this->get('translator')->trans('The data input is invalid'));
            }
        }

        return $this->render('SMAdminBundle:Menu:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'langList' => $langList,
            'defaultLanguage' => $defaultLanguage,
            'mnuTypeText' => $mnuTypeText,
            'mnuTypeLink' => $mnuTypeLink
        ));
    }

    /**
     * Displays a form to edit an existing CompanyType entity.
     *
     */
    public function editAction($id) {

        $entity = $this->getDoctrine()->getRepository("SMAdminBundle:Menu")
                ->find($id);

        if (!$entity) {
            //go to page index with error
            $this->getRequest()->getSession()->getFlashBag()
                    ->add('sm_flash_error', 'Could not find page with id ' . $id);

            return $this->redirect($this->generateUrl('admin_menu'));
        }

        //get list language
        $langList = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->findAll();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                if (!$entity->hasLanguage($language)) {
                    $catLanguage = new MenuLanguage();
                    $catLanguage->setLanguage($language);
                    $catLanguage->setMenu($entity);
                    $entity->addMenuLanguage($catLanguage);
                }
                if ($language->getIsDefault()) {
                    $defaultLanguage = $language;
                }
            }
        }

        if (!$this->getRequest()->isMethod('POST')) {
            // set referrer redirect
            $session = $this->getRequest()->getSession();
            $session->set('referrer', $this->getRequest()->server->get('HTTP_REFERER'));
        }

        $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
        $mnuTypeText = $container->getParameter('menu_type_text');
        $mnuTypeLink = $container->getParameter('menu_type_link');

        $form = $this->createForm(new MenuType(), $entity);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                //Set Url for menu
                //Set Url for menu
                $param = $entity->getParam();
                $type = $entity->getType();
                if ($type != $mnuTypeLink) {
                    $url = $this->buildUrlForMenu($type, $param, $entity->getId());
                    $entity->setUrl($url);
                }

                $entityManager = $this->getDoctrine()->getEntityManager();
                foreach ($entity->getMenuLanguages() as $catLanguage) {
                    $name = $catLanguage->getName();
                    if (empty($name)) {
                        $entity->removeMenuLanguage($catLanguage);
                        $entityManager->remove($catLanguage);
                    }
                }

                //Set created
                $currUser = $this->get('security.context')->getToken()->getUser();
                $entity->setUpdated($currUser);

                $entityManager->persist($entity);

                $entityManager->flush();
                $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The operation is success'));
                $referrer = $this->getRequest()->getSession()->get('referrer');

                if (!$referrer) {

                    return $this->redirect(
                        $this->generateUrl('admin_menu')
                    );
                } else {

                    return $this->redirect($referrer);
                }
            } else {
                $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_error', $this->get('translator')->trans('The data input is invalid'));
            }
        }

        return $this->render('SMAdminBundle:Menu:edit.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'langList' => $langList,
            'defaultLanguage' => $defaultLanguage,
            'mnuTypeText' => $mnuTypeText,
            'mnuTypeLink' => $mnuTypeLink
        ));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request request
     * @param int                                       $id      the id
     *
     * @return type
     */
    public function deleteAction(Request $request, $id) {
        $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:MenuLanguage");

        $rst = $rep->deleteByIds(array($id));
        if ($rst) {
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The operation is success'));
        }
        // set referrer redirect
        $referrer = $this->getRequest()->server->get('HTTP_REFERER');

        if (!$referrer) {

            return $this->redirect(
                $this->generateUrl('admin_menu')
            );
        } else {

            return $this->redirect($referrer);
        }
    }

    /**
     * up action
     *
     * @param type $id
     *
     * @return type
     */
    public function upAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('SMAdminBundle:Menu');
        $oCat = $repo->findOneById($id);
        if ($oCat->getParent()) {
            $repo->moveUp($oCat);
        }

        return $this->redirect(
            $this->getRequest()->headers->get('referer')
        );

    }

    /**
     * down action
     *
     * @param type $id
     *
     * @return type
     */
    public function downAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('SMAdminBundle:Menu');
        $oCat = $repo->findOneById($id);
        if ($oCat->getParent()) {
            $repo->moveDown($oCat);
        }

        return $this->redirect(
            $this->getRequest()->headers->get('referer')
        );
    }

    /**
     * get param of the menu type by caled ajax with param is type
     *
     * @param type $type
     * @return Response
     */
    public function getParamAction($type)
    {
        $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('SMAdminBundle:Menu');
        $options = $repo->getOptionParam($type);
        return new Response(json_encode($options));
    }

    /**
     * Build url for menu
     *
     * @param type $type
     * @param type $param
     *
     * @return string
     */
    private function buildUrlForMenu($type, $param = '', $idMenu = '')
    {
        $url = '';
        $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
        $em = $this->getDoctrine()->getEntityManager();

        $mnuTypeCompanyCat = $container->getParameter('menu_type_company_category');
        $mnuTypeCompanyDetail = $container->getParameter('menu_type_company_detail');
        $mnuTypeProductBranch = $container->getParameter('menu_type_product_branch');
        $mnuTypeProductDetail = $container->getParameter('menu_type_product_detail');
        $mnuTypeNewsCat = $container->getParameter('menu_type_news_category');
        $mnuTypeNewsDetail = $container->getParameter('menu_type_news_detail');
        $mnuTypePageDetail = $container->getParameter('menu_type_page_detail');
        $mnuTypeText = $container->getParameter('menu_type_text');

        switch ($type) {
            case $mnuTypeCompanyCat:
                $repo = $em->getRepository('SMAdminBundle:CompanyType');
                $url = "/company/view-cat/";
                $url = $this->getAliasForMenu($repo, $param, $url, $idMenu);
                break;
            case $mnuTypeCompanyDetail:
                $repo = $em->getRepository('SMAdminBundle:Company');
                $url = "/company/view-detail/";
                $url = $this->getAliasForMenu($repo, $param, $url, $idMenu);
                break;
            case $mnuTypeProductBranch:
                $repo = $em->getRepository('SMAdminBundle:Branch');
                $url = "/product/view-branch/";
                $url = $this->getAliasForMenu($repo, $param, $url, $idMenu);
                break;
            case $mnuTypeProductDetail:
                $repo = $em->getRepository('SMAdminBundle:Products');
                $url = "/product/detail/";
                $url = $this->getAliasForMenu($repo, $param, $url, $idMenu);
                break;
            case $mnuTypeNewsCat:
                $repo = $em->getRepository('SMAdminBundle:Category');
                $url = "/news/view-cat/";
                $url = $this->getAliasForMenu($repo, $param, $url, $idMenu);
                break;
            case $mnuTypeNewsDetail:
                $repo = $em->getRepository('SMAdminBundle:News');
                $url = "/news/detail/";
                $url = $this->getAliasForMenu($repo, $param, $url, $idMenu);
                break;
            case $mnuTypePageDetail:
                $repo = $em->getRepository('SMAdminBundle:Page');
                $url = "/page/detail/";
                $url = $this->getAliasForMenu($repo, $param, $url, $idMenu);
                break;
            case $mnuTypeText:
                $url = "#";
                break;
        }

        return $url;
    }


    /**
     *
     * @param type $repo
     * @param type $id
     * @param type $url
     *
     * @return string
     */
    private function getAliasForMenu($repo, $id, $url, $idMenu = '')
    {
        $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
        $ext = $container->getParameter('ext_nice_url');

        //get list language
        $repLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");
        $langList = $repLanguage->getList();
        $defaultLanguage = null;
        if (is_array($langList)) {
            foreach ($langList as $language) {
                if ($language->getIsDefault()) {
                    $defaultLanguage = $language;
                }
            }
        }
        $entity = $repo->find($id);

        $entity->setLanguage($defaultLanguage);
        $name = $entity->getCurrentLanguage()->getName();
        $name = \SM\Bundle\AdminBundle\Utilities\Helper::cleanString($name, '_');
        $alias =  $url. $name . "_$id.$ext";

        //check menu is exist in table menu
        $repMenu = $this->getDoctrine()->getRepository("SMAdminBundle:Menu");
        $isExist = $repMenu->findBy(array('url' => $alias));
        if ($isExist) {
            $lastestMenu = $repMenu->getLastestItem();
            $lastestId = $lastestMenu->getId() + 1;
            $alias =  $url. $name . "_$lastestId"."_$id.".$ext;
        }

        $isExist = $repMenu->findBy(array('url' => $alias));
        if ($isExist) {
            $lastestId = $lastestId + 1;
            $alias =  $url. $name . "_$lastestId"."_$id.".$ext;
        }


        return $alias;
    }

    /**
     * check url is exist in table menu
     *
     * @param type $url
     * @return boolean
     */
    private function checkUrlIsExist($url)
    {
        $isExist = false;
        if ($url) {
            $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Menu");
            $rst = $rep->findBy(array('url' => $url));
        }
        return $isExist;
    }

    /**
     * Delete all item
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return type
     */
    public function deleteAllAction(Request $request)
    {
        $id = $request->get('checklist');
        $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:MenuLanguage");

        $rst = $rep->deleteByIds($id);

        // set referrer redirect
        $referrer = $this->getRequest()->server->get('HTTP_REFERER');

        if ($rst) {
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The operation is success'));
        } else {
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The operation is fail'));
        }

        if (!$referrer) {

            return $this->redirect(
                $this->generateUrl('admin_news')
            );
        } else {

            return $this->redirect($referrer);
        }
    }

    /**
     *
     * @param type $position
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getMenuParentByPositionAction($position)
    {
        $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('SMAdminBundle:Menu');
        $options = $repo->getOptionParent($position);
        return new Response(json_encode($options));
    }
}
<?php

namespace SM\Bundle\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SM\Bundle\AdminBundle\Repository\MenuRepository;

class DefaultController extends Controller {
    
    /**
     * Render content for home page
     * 
     * @return type 
     */
    public function indexAction(Request $request) {
        
//        $repConfig = $this->getDoctrine()
//                        ->getRepository('SMAdminBundle:Config');
//        $repConfig->updateByVisitor();
        return $this->render('SMFrontBundle:Default:index.html.twig');
    }
    
    /**
     * Render menu left
     * 
     * @return type 
     */
    public function menuAction(Request $request)
    {
        $currentUrl = $this->getRequest()->getUri();
        $menus = array();
        
        $repMenu = $this->getDoctrine()
                        ->getRepository('SMAdminBundle:Menu');
        
        $mnuPosLeft = $this->container->getParameter('menu_position_left');
        $menuLeftTop = $repMenu->getOptionParent($mnuPosLeft);
        unset($menuLeftTop[0]); //unset for menu Lua Chon
        $menuLeftTop = $this->removeHostUrl($menuLeftTop);
        
        $mnuPosLeftBottom = $this->container->getParameter('menu_position_left_bottom');
        $menuLeftBottom = $repMenu->getOptionParent($mnuPosLeftBottom);
        unset($menuLeftBottom[0]);  //unset for menu Lua Chon
        $menuLeftBottom = $this->removeHostUrl($menuLeftBottom);
        
        $urlHost = $this->container->getParameter('host');
        $currentUrl = str_replace($urlHost, '', $currentUrl);
        
        return $this->render('SMFrontBundle:Default:menu.html.twig', array(
            'menuLeftTop' => $menuLeftTop,
            'menuLeftBottom' => $menuLeftBottom,
            'currentUrl' => $currentUrl
            
        ));
    }
    
    /**
     * Remove url host that to set active for menu
     * 
     * @param type $menus
     * @return type 
     */
    private function removeHostUrl($menus)
    {
        $urlHost = $this->container->getParameter('host');
        $rst = array();
        if (is_array($menus) && count($menus) > 0) {
            foreach ($menus as $mnu) {
                $mnu->url = str_replace($urlHost, '', $mnu->url);
                $rst[] = $mnu;
            }
        }
        return $rst;
    }
    
    /**
     * Render image slide
     * 
     * @return type 
     */
    public function slideImageAction()
    {
        $numberSlideShow = $this->container->getParameter('number_slide_show');
        
        $repMedia = $this->getDoctrine()
                        ->getRepository('SMAdminBundle:Media');
        $entities = $repMedia->getList($numberSlideShow, null, array('is_front' => 1), array('created_at' => 'DESC'));
        
        return $this->render('SMFrontBundle:Default:slide-image.html.twig', array(
            'entities' => $entities,
            'path' => '/web/' . $this->container->getParameter('upload')
        ));
    }
    
    /**
     * To count visitor
     * 
     * @return type 
     */
    public function counterAction()
    {
        $repConfig = $this->getDoctrine()
                        ->getRepository('SMAdminBundle:Config');
        $obj = $repConfig->findByName('number_visitor');
        $count = $obj->getValue();
        $arrCount = array();
        for ($i = 0; $i < strlen($count); $i ++) {
            $n = substr($count, $i, 1);
            $arrCount[] = $n;
        }
        
        return $this->render('SMFrontBundle:Default:counter.html.twig', array('arrCount' => $arrCount));
    }
    
    /**
     * Return support block
     * 
     * @return type 
     */
    public function supportAction()
    {
        $skypes = $this->container->getParameter('support_skype');
        $yahoos = $this->container->getParameter('support_yahoo');
        
        return $this->render('SMFrontBundle:Default:support.html.twig', array(
            'yahoos' => $yahoos,
            'skypes' => $skypes
        ));
    }
    
    /**
     * Render html fot block Footer
     * 
     * @return type 
     */
    public function footerAction()
    {
        $infos = array();
        return $this->render('SMFrontBundle:Default:footer.html.twig', array(
            'infos' => $infos
        ));
    }
    
    /**
     * Render block right of the page product cat
     * 
     * @return type 
     */
    public function rightAction()
    {
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : null;
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
        
        $perNewItemHotPage = $this->container->getParameter('per_item_new_front');
        //Get list product by BranchId
        $entities = $this->getDoctrine()
                ->getRepository("SMAdminBundle:ProductLanguage")
                ->getNewProduct($lang, $perNewItemHotPage, 0);
        
        $perNewsHotItemPage = $this->container->getParameter('per_item_news_hot_front');
        $newsEntities = $this->getDoctrine()
                ->getRepository("SMAdminBundle:NewsLanguage")
                ->getHotNews($lang, $perNewsHotItemPage, 0);
        
        $dir = '/web/images/upload/';
        $thumbDir = '/web/' . $this->container->getParameter('upload') 
                    . $this->container->getParameter('thumbUpload');
        
        $countWordNewsTitle = $this->container->getParameter('countWordNewsTitle');
        
        return $this->render('SMFrontBundle:Default:right.html.twig', array(
            'entities' => $entities,
            'newsEntities' => $newsEntities,
            'thumb' => $thumbDir,
            'dir' => $dir,
            'countWordNewsTitle' => $countWordNewsTitle
        ));
    }
    
    /**
     * change language
     *
     * @param type $lang Language key
     *
     * @return type
     */
    public function changeLanguageAction($lang)
    {
        $request = $this->getRequest();
        $session = $this->get('session');
        $locale = strtolower($lang);
        $session->set('_locale', $locale);
        $referer = $request->headers->get('referer');
        if (empty($referer)) {
            return $this->redirect('/');
        }
        
        return $this->redirect($referer);
    }
    
    public function showContactAction()
    {
        return $this->render('SMFrontBundle:Default:contact-show.html.twig', array(
        ));
    }
}

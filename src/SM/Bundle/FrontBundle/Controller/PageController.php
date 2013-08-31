<?php

namespace SM\Bundle\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SM\Bundle\AdminBundle\Repository\MenuRepository;
use SM\Bundle\AdminBundle\Utilities\Helper;

class PageController extends Controller {
    
    /**
     * View cat product by slug
     * 
     * @param type $slug
     * @return type 
     */
    public function detailAction($slug)
    {
        //Get branch id
        $id = Helper::getIdFromUrl($slug);
        
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
        
        $entity = $this->getDoctrine()
                ->getRepository("SMAdminBundle:PageLanguage")
                ->findByPageIdAndLang($id, $lang);
        
        $imgDir = '/web/' . $this->container->getParameter('upload');
                
        return $this->render('SMFrontBundle:Page:detail.html.twig', array(
            'entity' => $entity,
            'imgDir' => $imgDir
        ));
        
    }
}

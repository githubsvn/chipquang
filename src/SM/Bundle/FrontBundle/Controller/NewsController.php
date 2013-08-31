<?php

namespace SM\Bundle\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SM\Bundle\AdminBundle\Repository\MenuRepository;
use SM\Bundle\AdminBundle\Utilities\Helper;

class NewsController extends Controller {
    
    /**
     * View cat product by slug
     * 
     * @param type $page
     * @param type $slug
     * 
     * @return type 
     */
    public function viewCatAction($page, $slug)
    {
        //Get branch id
        $catId = Helper::getIdFromUrl($slug);
        $lastUrl = Helper::getLastUrlFromUrl($slug);
        
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
        
        $currentLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->find($lang);
        
        $criterias = array();
        $criterias[1] = array('fieldName' => 'status', 'op' => '=', 'fieldValue' => 1);
        
        $total = $this->getDoctrine()
                ->getRepository("SMAdminBundle:NewsLanguage")
                ->getTotalByLangAndNameAndCategory($lang, '', $catId, $criterias);
        
        //Total of item for each page
        $perItemPage = $this->container->getParameter('per_item_news_front');
        //Total of page for each paginator
        $perPage = $this->container->getParameter('per_page_front');
        //Total page
        $totalPage = ceil($total / $perItemPage);
        if ($page > $totalPage) {
            $page = $totalPage;
        } 
        if ($page <= 0) {
            $page = 1;
        }
        
        //Get total page range
        $totalRange = ceil($total / ($perItemPage * $perPage) );
        //Get current range of page
        $currentPageRange = ceil( ($page * $perItemPage) / ($perItemPage * $perPage));
        //Get start page of the current range
        $startPageOfCurrentRange = ceil((( ($currentPageRange - 1) * ($perItemPage * $perPage)) + 1) / $perItemPage);
        //previous range
        $previousPage = $startPageOfCurrentRange - 1;
        if ($previousPage <= 0) {
            $previousPage = 1;
        }
        //next page
        $nextPage = $startPageOfCurrentRange + $perPage;
        if ($nextPage >= $totalPage) {
            $nextPage = $totalPage;
        }
        
        $entities = $this->getDoctrine()
                ->getRepository("SMAdminBundle:NewsLanguage")
                ->findByLangAndNameAndCategory($lang, '', $catId, $perItemPage, ($page - 1) * $perItemPage, $criterias);
        
        $thumbDir = '/web/' . $this->container->getParameter('upload') 
                    . $this->container->getParameter('thumbUpload');
        $dir = '/web/images/upload/';
        
        $countWordNewsIntro = $this->container->getParameter('countWordNewsIntro');
        $countWordNewsTitleList = $this->container->getParameter('countWordNewsTitleList');
        
        return $this->render('SMFrontBundle:News:view-cat.html.twig', array(
            'entities' => $entities,
            'thumb' => $thumbDir,
            'dir' => $dir,
            'totalRange' => $totalRange,
            'currentPage' => $page,
            'currentPageRange' => $currentPageRange,
            'startPageOfCurrentRange' => $startPageOfCurrentRange,
            'previousPage' => $previousPage,
            'nextPage' => $nextPage,
            'perPage' => $perPage,
            'totalPage' => $totalPage,
            'total' => $total,
            'lastUrl' => $lastUrl,
            'countWordNewsIntro' => $countWordNewsIntro,
            'countWordNewsTitleList' => $countWordNewsTitleList,
        ));
        
    }
    
    /**
     * 
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
                ->getRepository("SMAdminBundle:NewsLanguage")
                ->findByNewsIdAndLang($id, $lang);
        
        $newsLastest = $this->getDoctrine()
                ->getRepository("SMAdminBundle:NewsLanguage")
                ->getNewsLastestByNewsIdAndLangId($id, $lang);
        
        $newsOldest = $this->getDoctrine()
                ->getRepository("SMAdminBundle:NewsLanguage")
                ->getNewsOldestByNewsIdAndLangId($id, $lang);
        $imgDir = '/web/' . $this->container->getParameter('upload');
                
        return $this->render('SMFrontBundle:News:detail.html.twig', array(
            'entity' => $entity,
            'newsLastest' => $newsLastest,
            'newsOldest' => $newsOldest,
            'imgDir' => $imgDir
        ));
    }
}

<?php

namespace SM\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SM\Bundle\AdminBundle\Entity\Products;
use SM\Bundle\AdminBundle\Form\ProductsType;
use SM\Bundle\AdminBundle\Utilities\Helper;
use SM\Bundle\AdminBundle\Utilities\Utilities;

/**
 * Products controller.
 *
 */
class ProductsController extends Controller
{
    private $uploadDir;
    private $thumbDir;
    private $uploadPath;
    private $thumbPath;
    
    /**
     * 
     */
    public function __construct() {
        $container = \SM\Bundle\AdminBundle\SMAdminBundle::getContainer();
        $dirRoot = Utilities::getRootDir();
        $this->uploadDir = $dirRoot . $container->getParameter('upload');
        $this->thumbDir = $dirRoot . $container->getParameter('thumbUpload');
        $this->uploadPath = $container->getParameter('thumbUpload');
        $this->thumbPath = $container->getParameter('thumbUpload');
    }
    
    /**
     * Lists all Products entities.
     *
     */
    public function indexAction($page, $lang)
    {
        if ($this->getRequest()->isMethod('POST')) {
            $_SESSION['lang'] = $this->getRequest()->request->get('language', '');
            $_SESSION['name'] = $this->getRequest()->request->get('name', '');
            $_SESSION['branch'] = $this->getRequest()->request->get('branch', null);
        }

        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $lang;
        $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
        $branchId = isset($_SESSION['branch']) ? $_SESSION['branch'] : '';

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

        $total = $this->getDoctrine()
                ->getRepository("SMAdminBundle:ProductLanguage")
                ->getTotalByLangAndNameAndType($lang, $name, $branchId);

        $perPage = $this->container->getParameter('per_item_page');
        $lastPage = ceil($total / $perPage);
        $previousPage = $page > 1 ? $page - 1 : 1;
        $nextPage = $page < $lastPage ? $page + 1 : $lastPage;

        $entities = $this->getDoctrine()
                ->getRepository("SMAdminBundle:ProductLanguage")
                ->findByLangAndNameAndBranchAndProductGroup($lang, $name, $branchId, $perPage, ($page - 1) * $perPage);

        //Get branch and product group
        $criteria = array();
        $criteria[] = array('op' => '=', 'fieldName' => 'status', 'fieldValue' => '1');
        $repBranch = $this->getDoctrine()->getRepository('SMAdminBundle:Branch');
        $optBranchs = $repBranch->getList(null, null, $criteria, array('lft' => 'ASC'));
        foreach ($optBranchs as $oItem) {
            $oItem->setLanguage($currentLanguage);
        }

        return $this->render('SMAdminBundle:Products:index.html.twig', array(
                    'entities' => $entities,
                    'lastPage' => $lastPage,
                    'previousPage' => $previousPage,
                    'currentPage' => $page,
                    'nextPage' => $nextPage,
                    'total' => $total,
                    'lang' => intval($lang),
                    'name' => $name,
                    'branchId' => $branchId,
                    'langList' => $langList,
                    'optBranchs' => $optBranchs,
                ));
    }

    /**
     * Finds and displays a Products entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SMAdminBundle:Products')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Products entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:Products:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to create a new Products entity.
     *
     */
    public function newAction()
    {
        $entity = new Products();
        //get list language
        $repLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");
        //Get list language
        $langList = $repLanguage->getList();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                $oLanguage = new \SM\Bundle\AdminBundle\Entity\ProductLanguage();
                $oLanguage->setLanguage($language);
                $oLanguage->setProduct($entity);
                $entity->addProductLanguage($oLanguage);

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

        $form = $this->createForm(new ProductsType(), $entity);
        
        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {

                //Set created and updated user
                $currUser = $this->get('security.context')->getToken()->getUser();
                $entity->setCreated($currUser);
                $entity->setUpdated($currUser);

                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($entity);
                foreach ($entity->getProductLanguages() as $oLanguage) {
                    $name = $oLanguage->getName();

                    if (empty($name)) {
                        $entity->removeProductLanguage($oLanguage);
                        $entityManager->remove($oLanguage);
                    }
                }

                //Upload logo for company
                if (!empty($entity->thumb)) {
                    $newName = Utilities::renameForFile($entity->thumb->getClientOriginalName());
                    //get upload dir
                    //upload file
                    $entity->thumb->move($this->uploadDir, $newName);
                    //set new name
                    $entity->setThumb($newName);
                    //Create thumbnail for image
                    Helper::createThumb($newName);
                }

                $entityManager->flush();

                $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The operation is success'));

                $referrer = $this->getRequest()->getSession()->get('referrer');

                if (!$referrer) {
                    return $this->redirect(
                                    $this->generateUrl('admin_products')
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

        //get Medias
        $optMedias = $this->getDoctrine()->getRepository("SMAdminBundle:Media")
                ->findAll();

        //Get media category name that to display add news
        $langList = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->findAll();
        foreach ($langList as $langData) {
            $isDefault = $langData->getIsDefault();
            if ($isDefault == 1) {
                $lang = $langData->getId();
                break;
            }
        }
        $currentLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->find($lang);

        $criteria = array();
        $criteria[] = array('op' => '>', 'fieldName' => 'lft', 'fieldValue' => '1');
        $criteria[] = array('op' => '=', 'fieldName' => 'status', 'fieldValue' => '1');

        $listMediaCats = $this->getDoctrine()
                ->getRepository("SMAdminBundle:MediaCategory")
                ->getList(null, null, $criteria, array('lft' => 'ASC'));
        foreach ($listMediaCats as $theCat) {
            $theCat->setLanguage($currentLanguage);
        }

        return $this->render('SMAdminBundle:Products:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'langList' => $langList,
                    'defaultLanguage' => $defaultLanguage,
                    'optMedias' => $optMedias,
                    'selectedMedias' => array(),
                    'mediaPath' => $this->uploadDir,
                    'optMediaTypes' => $listMediaCats
                ));
    }

    /**
     * Displays a form to edit an existing Products entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->getDoctrine()->getRepository("SMAdminBundle:Products")
                ->find($id);

        if (!$entity) {
            //go to page index with error
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_error', $this->get('translator')->trans('Unable to find entity'));

            return $this->redirect($this->generateUrl('admin_products'));
        }

        //get list language
        $repLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");
        //Get list language
        $langList = $repLanguage->getList();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                if (!$entity->hasLanguage($language)) {
                    $oLanguage = new \SM\Bundle\AdminBundle\Entity\ProductLanguage();
                    $oLanguage->setLanguage($language);
                    $oLanguage->setProduct($entity);

                    $entity->addProductLanguage($oLanguage);
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

        //get upload dir
        $thumb = $entity->getThumb();
        $form = $this->createForm(new ProductsType(), $entity);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {

                //Set created and updated user
                $currUser = $this->get('security.context')->getToken()->getUser();
                $entity->setUpdated($currUser);

                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($entity);
                foreach ($entity->getProductLanguages() as $oLanguage) {
                    $name = $oLanguage->getName();

                    if (empty($name)) {
                        $entity->removeProductLanguage($oLanguage);
                        $entityManager->remove($oLanguage);
                    }
                }

                //Upload logo for company
                if (!empty($entity->thumb)) {
                    $newName = Utilities::renameForFile($entity->thumb->getClientOriginalName());
                    //upload file
                    $entity->thumb->move($this->uploadDir, $newName);
                    //set new name
                    $entity->setThumb($newName);
                    //Create thumbnail for image
                    Helper::createThumb($newName);

                    //Delete old logo file
                    $oldFileThumb = $this->uploadDir . '/' . $thumb;
                    $oldThumbFileImage = $this->thumbDir . '/' . $thumb;
                    
                    if (file_exists($oldFileThumb)) {
                        @unlink($oldFileThumb);
                    }
                    if (file_exists($oldThumbFileImage)) {
                        @unlink($oldThumbFileImage);
                    }
                } else {
                    //Check input delImgs if exist we need to delete logo of the company
                    if (!empty($_POST['delImgs'])) {
                        foreach ($_POST['delImgs'] as $img) {
                            $fileThumb = $this->uploadDir . '/' . $img;
                            //delete image
                            if (file_exists($fileThumb)) {
                                @unlink($fileThumb);
                                $entity->setThumb('');
                            }
                            //delete thumb
                            $oldThumbFileImage = $this->thumbDir . '/' . $img;
                            if (file_exists($oldThumbFileImage)) {
                                @unlink($oldThumbFileImage);
                            }
                        }
                    } else {
                        //we dont'want to remove logo. we need to get old logo
                        $entity->setThumb($thumb);
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
                                    $this->generateUrl('admin_products')
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

        //get Medias
        $optMedias = $this->getDoctrine()->getRepository("SMAdminBundle:Media")
                ->findAll();

        //Get media category name that to display add news
        $langList = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->findAll();
        foreach ($langList as $langData) {
            $isDefault = $langData->getIsDefault();
            if ($isDefault == 1) {
                $lang = $langData->getId();
                break;
            }
        }
        $currentLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->find($lang);
        $criteria = array();
        $criteria[] = array('op' => '>', 'fieldName' => 'lft', 'fieldValue' => '1');
        $criteria[] = array('op' => '=', 'fieldName' => 'status', 'fieldValue' => '1');

        $listMediaCats = $this->getDoctrine()
                ->getRepository("SMAdminBundle:MediaCategory")
                ->getList(null, null, $criteria, array('lft' => 'ASC'));
        foreach ($listMediaCats as $theCat) {
            $theCat->setLanguage($currentLanguage);
        }

        return $this->render('SMAdminBundle:Products:edit.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'langList' => $langList,
            'defaultLanguage' => $defaultLanguage,
            'arrImgs' => array($thumb),
            'imgPath' => $this->thumbPath,
            'optMedias' => $optMedias,
            'mediaPath' => $this->thumbPath,
            'optMediaTypes' => $listMediaCats,
        ));

    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request request
     * @param int                                       $id      the id
     *
     * @return type
     */
    public function deleteAction(Request $request, $id)
    {
        $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:ProductLanguage");

        $rst = $rep->deleteByIds(array($id));

        // set referrer redirect
        $referrer = $this->getRequest()->server->get('HTTP_REFERER');

        if ($rst) {
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The operation is success'));

            return $this->redirect(
                $this->generateUrl('admin_products')
            );
        } else {
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_error', $this->get('translator')->trans('The operation is fail'));
            
            return $this->redirect($referrer);
        }
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
                ->getRepository("SMAdminBundle:ProductLanguage");

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
                     ->add('sm_flash_error', $this->get('translator')->trans('The operation is fail'));
        }

        if (!$referrer) {

            return $this->redirect(
                $this->generateUrl('admin_news')
            );
        } else {

            return $this->redirect($referrer);
        }
    }
}

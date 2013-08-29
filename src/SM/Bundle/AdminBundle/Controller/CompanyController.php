<?php

namespace SM\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SM\Bundle\AdminBundle\Entity\Company;
use SM\Bundle\AdminBundle\Entity\CompanyLanguage;
use SM\Bundle\AdminBundle\Form\CompanyType;
use SM\Bundle\AdminBundle\Utilities\Utilities;
use SM\Bundle\AdminBundle\Utilities\Helper;

/**
 * Company controller.
 *
 */
class CompanyController extends Controller
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
    
    public function indexAction($page, $lang)
    {
        if ($this->getRequest()->isMethod('POST')) {
            $_SESSION['lang'] = $this->getRequest()->request->get('language', '');
            $_SESSION['name'] = $this->getRequest()->request->get('name', '');
            $_SESSION['type'] = $this->getRequest()->request->get('type', '');
        }
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : $lang;
        $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
        $type = isset($_SESSION['type']) ? $_SESSION['type'] : '';

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

        //Get total of the company language and company
        $total = $this->getDoctrine()
                ->getRepository("SMAdminBundle:CompanyLanguage")
                ->getTotalByLangAndNameAndType($lang, $name, $type);

        //calculate for limit and offset
        $perPage = $this->container->getParameter('per_item_page');
        $lastPage = ceil($total / $perPage);
        $previousPage = $page > 1 ? $page - 1 : 1;
        $nextPage = $page < $lastPage ? $page + 1 : $lastPage;

        $entities = $this->getDoctrine()
                ->getRepository("SMAdminBundle:CompanyLanguage")
                ->findByLangAndNameAndType($lang, $name, $type, $perPage, ($page - 1) * $perPage);

        //Set data for company type on form search
        $repComType = $this->getDoctrine()->getRepository('SMAdminBundle:CompanyType');
        $optComTypes = $repComType->getList();
        foreach ($optComTypes as $oComType) {
            $oComType->setLanguage($currentLanguage);
        }

        //Assign to view
        return $this->render('SMAdminBundle:Company:index.html.twig', array(
                    'entities' => $entities,
                    'lastPage' => $lastPage,
                    'previousPage' => $previousPage,
                    'currentPage' => $page,
                    'nextPage' => $nextPage,
                    'total' => $total,
                    'lang' => intval($lang),
                    'name' => $name,
                    'type' => $type,
                    'langList' => $langList,
                    'optComTypes' => $optComTypes
                ));
    }

    /**
     * Finds and displays a Company entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SMAdminBundle:Company')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('Unable to find entity'));
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:Company:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to create a new Company entity.
     *
     */
    public function newAction()
    {
        $entity = new Company();
        //get list language
        $repLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");
        //Get list language
        $langList = $repLanguage->getList();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                $companyLanguage = new CompanyLanguage();
                $companyLanguage->setLanguage($language);
                $companyLanguage->setCompany($entity);

                $entity->addCompanyLanguage($companyLanguage);

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

        $form = $this->createForm(new CompanyType(), $entity);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {

                //Set created and updated user
                $currUser = $this->get('security.context')->getToken()->getUser();
                $entity->setCreated($currUser);
                $entity->setUpdated($currUser);

                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($entity);
                foreach ($entity->getCompanyLanguages() as $companyLanguage) {
                    $name = $companyLanguage->getName();

                    if (empty($name)) {
                        $entity->removeCompanyLanguage($companyLanguage);
                        $entityManager->remove($companyLanguage);
                    }
                }

                //Upload logo for company
                if (!empty($entity->logo)) {
                    $newName = Utilities::renameForFile($entity->logo->getClientOriginalName());
                    //upload file
                    $entity->logo->move($this->uploadDir, $newName);
                    //set new name
                    $entity->setLogo($newName);
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
                                    $this->generateUrl('admin_company')
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

        return $this->render('SMAdminBundle:Company:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'langList' => $langList,
                    'defaultLanguage' => $defaultLanguage
                ));
    }

    /**
     * Displays a form to edit an existing Company entity.
     *
     */
    public function editAction($id)
    {
        $entity = $this->getDoctrine()->getRepository("SMAdminBundle:Company")
                ->find($id);

        if (!$entity) {
            //go to page index with error
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_error', $this->get('translator')->trans('Could not find page with id' . ' ' . $id));

            return $this->redirect($this->generateUrl('admin_company'));
        }

        //get list language
        $repLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");
        //Get list language
        $langList = $repLanguage->getList();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                if (!$entity->hasLanguage($language)) {
                    $companyLanguage = new CompanyLanguage();
                    $companyLanguage->setLanguage($language);
                    $companyLanguage->setCompany($entity);

                    $entity->addCompanyLanguage($companyLanguage);
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
        $logo = $entity->getLogo();
        $form = $this->createForm(new CompanyType(), $entity);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {

                //Set created and updated user
                $currUser = $this->get('security.context')->getToken()->getUser();
                $entity->setUpdated($currUser);

                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($entity);
                foreach ($entity->getCompanyLanguages() as $companyLanguage) {
                    $name = $companyLanguage->getName();

                    if (empty($name)) {
                        $entity->removeCompanyLanguage($companyLanguage);
                        $entityManager->remove($companyLanguage);
                    }
                }

                //Upload logo for company
                if (!empty($entity->logo)) {
                    $newName = Utilities::renameForFile($entity->logo->getClientOriginalName());
                    //upload file
                    $entity->logo->move($this->uploadDir, $newName);
                    //set new name
                    $entity->setLogo($newName);
                    Helper::createThumb($newName);
                    
                    //Delete old logo file
                    $oldFileThumb = $this->uploadDir . '/' . $logo;
                    $oldThumbFileImage = $this->thumbDir . '/' . $logo;
                    
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
                        $entity->setLogo($logo);
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
                                    $this->generateUrl('admin_company')
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

        return $this->render('SMAdminBundle:Company:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                    'langList' => $langList,
                    'defaultLanguage' => $defaultLanguage,
                    'arrImgs' => array($logo),
                    'imgPath' => $this->thumbPath
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
                ->getRepository("SMAdminBundle:CompanyLanguage");

        $rst = $rep->deleteByIds(array($id));

        // set referrer redirect
        $referrer = $this->getRequest()->server->get('HTTP_REFERER');

        if ($rst) {
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The operation is success'));

            return $this->redirect(
                $this->generateUrl('admin_company')
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
                ->getRepository("SMAdminBundle:CompanyLanguage");

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
                $this->generateUrl('admin_company')
            );
        } else {

            return $this->redirect($referrer);
        }
    }
}

<?php

namespace SM\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SM\Bundle\AdminBundle\Entity\Category;
use SM\Bundle\AdminBundle\Entity\CategoryLanguage;
use SM\Bundle\AdminBundle\Form\CategoryType;
use SM\Bundle\AdminBundle\Form\CategoryLanguageType;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{
    /**
     *
     * @param type $page
     * @param type $lang
     * @return type
     */
    public function indexAction($page, $lang) {
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

        $total = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Category")
                ->getTotal($criteria);

        $perPage = $this->container->getParameter('per_item_page');
        $lastPage = ceil($total / $perPage);
        $previousPage = $page > 1 ? $page - 1 : 1;
        $nextPage = $page < $lastPage ? $page + 1 : $lastPage;

        $entities = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Category")
                ->getList($perPage, ($page - 1) * $perPage, $criteria, array('lft' => 'ASC'));

        foreach ($entities as $theCat) {
            $theCat->setLanguage($currentLanguage);
        }

        return $this->render('SMAdminBundle:Category:index.html.twig', array(
            'entities' => $entities,
            'lastPage' => $lastPage,
            'previousPage' => $previousPage,
            'currentPage' => $page,
            'nextPage' => $nextPage,
            'total' => $total,
            'lang' => intval($lang),
            'langList' => $langList,
        ));
    }

    /**
     * Finds and displays a CompanyType entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SMAdminBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CompanyType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:Category:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to create a new CompanyType entity.
     *
     */
    public function newAction() {
        $entity = new Category();
        //get list language
        $repLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");
        //Get list language
        $langList = $repLanguage->getList();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                $catLanguage = new CategoryLanguage();
                $catLanguage->setLanguage($language);
                $catLanguage->setCategory($entity);

                $entity->addCategoryLanguage($catLanguage);

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

        $form = $this->createForm(new CategoryType(), $entity);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {

                //Set created and updated user
                $currUser = $this->get('security.context')->getToken()->getUser();
                $entity->setCreated($currUser);
                $entity->setUpdated($currUser);

                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($entity);
                foreach ($entity->getCategoryLanguages() as $catLanguage) {
                    $name = $catLanguage->getName();
                    if (empty($name)) {
                        $entity->removeCategoryLanguage($catLanguage);
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
                        $this->generateUrl('admin_category')
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

        return $this->render('SMAdminBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'langList' => $langList,
            'defaultLanguage' => $defaultLanguage
        ));
    }

    /**
     * Displays a form to edit an existing CompanyType entity.
     *
     */
    public function editAction($id) {

        $entity = $this->getDoctrine()->getRepository("SMAdminBundle:Category")
                ->find($id);

        if (!$entity) {
            //go to page index with error
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_error', $this->get('translator')->trans('Unable to find entity'));

            return $this->redirect($this->generateUrl('admin_category'));
        }

        //get list language
        $langList = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->findAll();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                if (!$entity->hasLanguage($language)) {
                    $catLanguage = new CategoryLanguage();
                    $catLanguage->setLanguage($language);
                    $catLanguage->setCategory($entity);
                    $entity->addCategoryLanguage($ctLanguage);
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

        $form = $this->createForm(new CategoryType(), $entity);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getEntityManager();
                foreach ($entity->getCategoryLanguages() as $catLanguage) {
                    $name = $catLanguage->getName();
                    if (empty($name)) {
                        $entity->removeCategoryLanguage($catLanguage);
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
                        $this->generateUrl('admin_category')
                    );
                } else {

                    return $this->redirect($referrer);
                }
            } else {
                $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The data input is invalid'));
            }
        }

        return $this->render('SMAdminBundle:Category:edit.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'langList' => $langList,
            'defaultLanguage' => $defaultLanguage,
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
                ->getRepository("SMAdminBundle:CategoryLanguage");

        $rst = $rep->deleteByIds(array($id));

        // set referrer redirect
        $referrer = $this->getRequest()->server->get('HTTP_REFERER');

        if ($rst) {
            $this->getRequest()
                     ->getSession()
                     ->getFlashBag()
                     ->add('sm_flash_success', $this->get('translator')->trans('The operation is success'));

            return $this->redirect(
                $this->generateUrl('admin_category')
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
     * up action
     *
     * @param type $id
     *
     * @return type
     */
    public function upAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repo = $em->getRepository('SMAdminBundle:Category');
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
        $repo = $em->getRepository('SMAdminBundle:Category');
        $oCat = $repo->findOneById($id);
        if ($oCat->getParent()) {
            $repo->moveDown($oCat);
        }

        return $this->redirect(
            $this->getRequest()->headers->get('referer')
        );
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
                ->getRepository("SMAdminBundle:CategoryLanguage");

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

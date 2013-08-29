<?php

namespace SM\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SM\Bundle\AdminBundle\Entity\Branch;
use SM\Bundle\AdminBundle\Entity\BranchLanguage;
use SM\Bundle\AdminBundle\Form\BranchType;

/**
 * Branch controller.
 *
 */
class BranchController extends Controller
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
                ->getRepository("SMAdminBundle:Branch")
                ->getTotal($criteria);

        $perPage = $this->container->getParameter('per_item_page');
        $lastPage = ceil($total / $perPage);
        $previousPage = $page > 1 ? $page - 1 : 1;
        $nextPage = $page < $lastPage ? $page + 1 : $lastPage;

        $entities = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Branch")
                ->getList($perPage, ($page - 1) * $perPage, $criteria, array('lft' => 'ASC'));

        foreach ($entities as $theCat) {
            $theCat->setLanguage($currentLanguage);
        }

        return $this->render('SMAdminBundle:Branch:index.html.twig', array(
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

        $entity = $em->getRepository('SMAdminBundle:Branch')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CompanyType entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:Branch:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to create a new CompanyType entity.
     *
     */
    public function newAction() {
        $entity = new Branch();
        //get list language
        $repLanguage = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");
        //Get list language
        $langList = $repLanguage->getList();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                $catLanguage = new BranchLanguage();
                $catLanguage->setLanguage($language);
                $catLanguage->setBranch($entity);

                $entity->addBranchLanguage($catLanguage);

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

        $form = $this->createForm(new BranchType(), $entity);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {

                //Set created and updated user
                $currUser = $this->get('security.context')->getToken()->getUser();
                $entity->setCreated($currUser);
                $entity->setUpdated($currUser);

                $entityManager = $this->getDoctrine()->getEntityManager();
                $entityManager->persist($entity);
                foreach ($entity->getBranchLanguages() as $catLanguage) {
                    $name = $catLanguage->getName();
                    if (empty($name)) {
                        $entity->removeBranchLanguage($catLanguage);
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
                        $this->generateUrl('admin_branch')
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

        return $this->render('SMAdminBundle:Branch:new.html.twig', array(
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

        $entity = $this->getDoctrine()->getRepository("SMAdminBundle:Branch")
                ->find($id);

        if (!$entity) {
            //go to page index with error
            $this->getRequest()->getSession()->getFlashBag()
                    ->add('sm_flash_error', 'Could not find page with id ' . $id);


            return $this->redirect($this->generateUrl('admin_branch'));
        }

        //get list language
        $langList = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->findAll();

        if (is_array($langList)) {
            foreach ($langList as $language) {
                if (!$entity->hasLanguage($language)) {
                    $catLanguage = new BranchLanguage();
                    $catLanguage->setLanguage($language);
                    $catLanguage->setBranch($entity);
                    $entity->addBranchLanguage($ctLanguage);
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

        $form = $this->createForm(new BranchType(), $entity);

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());

            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getEntityManager();
                foreach ($entity->getBranchLanguages() as $catLanguage) {
                    $name = $catLanguage->getName();
                    if (empty($name)) {
                        $entity->removeBranchLanguage($catLanguage);
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
                        $this->generateUrl('admin_branch')
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

        return $this->render('SMAdminBundle:Branch:edit.html.twig', array(
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
                ->getRepository("SMAdminBundle:BranchLanguage");

        $rst = $rep->deleteByIds(array($id));

        // set referrer redirect
        $referrer = $this->getRequest()->server->get('HTTP_REFERER');

        if ($rst) {

            return $this->redirect(
                $this->generateUrl('admin_branch')
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
        $repo = $em->getRepository('SMAdminBundle:Branch');
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
        $repo = $em->getRepository('SMAdminBundle:Branch');
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
                ->getRepository("SMAdminBundle:BranchLanguage");

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

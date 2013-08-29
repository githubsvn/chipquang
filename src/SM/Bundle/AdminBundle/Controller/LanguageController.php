<?php

namespace SM\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SM\Bundle\AdminBundle\Entity\Language;
use SM\Bundle\AdminBundle\Form\LanguageType;

/**
 * Language controller.
 *
 */
class LanguageController extends Controller
{

    /**
     * index action
     *
     * @param type $page page
     *
     * @return type
     */
    public function indexAction($page)
    {
        $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");

        $total = $rep->getTotal();
        $perPage = $this->container->getParameter('per_item_page');

        $lastPage = ceil($total / $perPage);
        $previousPage = $page > 1 ? $page - 1 : 1;
        $nextPage = $page < $lastPage ? $page + 1 : $lastPage;

        $entities = $rep->getList($perPage, ($page - 1) * $perPage);

        return $this->render('SMAdminBundle:Language:index.html.twig', array(
                    'entities' => $entities,
                    'lastPage' => $lastPage,
                    'previousPage' => $previousPage,
                    'currentPage' => $page,
                    'nextPage' => $nextPage,
                    'total' => $total
                ));
    }

    /**
     * show action
     *
     * @param type $id the id
     *
     * @return type
     *
     * @throws type
     */
    public function showAction($id)
    {
        $entity = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Language entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:Language:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * new action
     *
     * @return type
     */
    public function newAction()
    {
        $entity = new Language();
        $form = $this->createForm(new LanguageType(), $entity);

        return $this->render('SMAdminBundle:Language:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
    }

    /**
     * create action
     *
     * @param \Symfony\Component\HttpFoundation\Request $request request
     *
     * @return typeaddByEntity
     */
    public function createAction(Request $request)
    {
        $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");

        $entity = new Language();
        $form = $this->createForm(new LanguageType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            if (is_object($entity)) {
                $id = $rep->addByEntity($entity);
            }

            //unset default for other langauge
            $isDefault = $entity->getIsDefault();
            if ($isDefault) {
                $rep->setDefaultById($entity->getId());
            }

            return $this->redirect(
                            $this->generateUrl('admin_language_show', array('id' => $entity->getId())
                            ));
        }

        return $this->render('SMAdminBundle:Language:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
                ));
    }

    /**
     * @param type $id the id
     *
     * @return type
     *
     * @throws type
     */
    public function editAction($id)
    {
        $entity = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language")
                ->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Language entity.');
        }

        $editForm = $this->createForm(new LanguageType($entity->getIsDefault()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:Language:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
    }

    /**
     * update action
     *
     * @param \Symfony\Component\HttpFoundation\Request $request request
     *
     * @param type                                      $id      the id
     *
     * @return type
     *
     * @throws type
     */
    public function updateAction(Request $request, $id)
    {
        $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");

        $entity = $rep->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Language entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new LanguageType($entity->getIsDefault()), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $rep->addByEntity($entity);

            //unset default for other langauge
            $isDefault = $entity->getIsDefault();
            if ($isDefault) {
                $rep->setDefaultById($entity->getId());
            }

            return $this->redirect(
                            $this->generateUrl('admin_language_edit', array('id' => $id)
                            ));
        }

        return $this->render('SMAdminBundle:Language:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                ));
    }

    /**
     * delete action
     *
     * @param \Symfony\Component\HttpFoundation\Request $request request
     *
     * @param type                                      $id      the id
     *
     * @return type
     */
    public function deleteAction(Request $request, $id)
    {
        $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");

        $rst = $rep->deleteByIds(array($id));

        return $this->redirect(
                        $this->generateUrl('admin_language')
        );
    }

    /**
     * action
     *
     * @param type $id the id
     *
     * @return type
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm();
    }

    /**
     * set default for language
     *
     * @param \Symfony\Component\HttpFoundation\Request $request request
     *
     * @param type                                      $id      the id
     *
     * @return type
     */
    public function setDefaultAction(Request $request, $id)
    {
        $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Language");
        $rst = $rep->setDefaultById($id);

        return $this->redirect(
                        $this->generateUrl('admin_language')
        );
    }

}

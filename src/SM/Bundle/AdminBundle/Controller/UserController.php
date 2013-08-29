<?php

namespace SM\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SM\Bundle\AdminBundle\Entity\User;
use SM\Bundle\AdminBundle\Form\UserType;
use SM\Bundle\AdminBundle\Form\ProfileType;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all User entities.
     *
     * @return type
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entities = $entityManager->getRepository('SMAdminBundle:User')->findAll();

        return $this->render('SMAdminBundle:User:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     * @param type $id the id
     *
     * @return type
     *
     * @throws type
     */
    public function showAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $entityManager->getRepository('SMAdminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:User:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @return type
     */
    public function newAction()
    {
        $entity = new User();
        $form   = $this->createForm(new UserType(), $entity);

        return $this->render('SMAdminBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new User entity.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request request
     *
     * @return type
     */
    public function createAction(Request $request)
    {
        $entity  = new User();
        $form = $this->createForm(new UserType(), $entity);
        $form->bind($request);
        if ($form->isValid()) {

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
            $entity->setPassword($password);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entity);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $entity->getId())));
        }

        return $this->render('SMAdminBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @param type $id the id
     *
     * @return type
     *
     * @throws type
     */
    public function editAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $entityManager->getRepository('SMAdminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createForm(new ProfileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing User entity.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request request
     * @param type                                      $id      id
     *
     * @return type
     *
     * @throws type
     */
    public function updateAction(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entity = $entityManager->getRepository('SMAdminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $oldPassword = $entity->getPassword();
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ProfileType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            // Check current password
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
            $currentPassword = $encoder->encodePassword($entity->getCurrentPassword(), $entity->getSalt());
            if ($currentPassword == $oldPassword && $entity->getPassword() != null && $entity->getCurrentPassword() != null) {
                $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
                $entity->setPassword($password);

                $entityManager->persist($entity);
                $entityManager->flush();

                $this->getRequest()->getSession()->getFlashBag()->add('sm_flash_success', 'Update user successfully!');
            } else {
                if ($entity->getCurrentPassword() == null) {
                    $entity->setPassword($oldPassword);
                    $entityManager->persist($entity);
                    $entityManager->flush();

                    $this->getRequest()->getSession()->getFlashBag()->add('sm_flash_success', 'Update user successfully!');
                } else {
                    $this->getRequest()->getSession()->getFlashBag()->add('sm_flash_error', 'Current password not match with database');
                }
            }

            return $this->redirect($this->generateUrl('admin_user_edit', array('id' => $id)));
        }

        return $this->render('SMAdminBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request request
     * @param type                                      $id      the id
     *
     * @return type
     *
     * @throws type
     */
    public function deleteAction(Request $request, $id)
    {
        if ($request->getMethod() == 'POST') {
            $entityManager = $this->getDoctrine()->getManager();
            $entity = $entityManager->getRepository('SMAdminBundle:User')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $entityManager->remove($entity);
            $entityManager->flush();
        }

        return $this->redirect($this->generateUrl('admin_user'));
    }

    /**
     * create delete form
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
}

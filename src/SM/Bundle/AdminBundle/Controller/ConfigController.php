<?php

namespace SM\Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SM\Bundle\AdminBundle\Entity\Config;
use SM\Bundle\AdminBundle\Form\ConfigType;

/**
 * Config controller.
 *
 */
class ConfigController extends Controller
{
    /**
     * Lists all Config entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SMAdminBundle:Config')->findAll();

        return $this->render('SMAdminBundle:Config:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Finds and displays a Config entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SMAdminBundle:Config')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Config entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:Config:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to create a new Config entity.
     *
     */
    public function newAction()
    {
        $entity = new Config();
        $form   = $this->createForm(new ConfigType(), $entity);

        return $this->render('SMAdminBundle:Config:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Config entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Config();
        $form = $this->createForm(new ConfigType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_config_show', array('id' => $entity->getId())));
        }

        return $this->render('SMAdminBundle:Config:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Config entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SMAdminBundle:Config')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Config entity.');
        }

        $editForm = $this->createForm(new ConfigType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SMAdminBundle:Config:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Config entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SMAdminBundle:Config')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Config entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ConfigType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_config'));
        }

        return $this->render('SMAdminBundle:Config:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Config entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $rep = $this->getDoctrine()
                ->getRepository("SMAdminBundle:Config");

        $rst = $rep->deleteByIds(array($id));

        return $this->redirect(
                $this->generateUrl('admin_config')
        );
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
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
                ->getRepository("SMAdminBundle:Config");

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
                $this->generateUrl('admin_config')
            );
        } else {

            return $this->redirect($referrer);
        }
    }
}

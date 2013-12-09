<?php

namespace Flosy\Bundle\UseCaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Flosy\Bundle\UseCaseBundle\Entity\UseCase;
use Flosy\Bundle\UseCaseBundle\Form\UseCaseType;

/**
 * UseCase controller.
 *
 * @Route("/usecase")
 */
class UseCaseController extends Controller
{

    /**
     * Lists all UseCase entities.
     *
     * @Route("/", name="usecase")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FlosyUseCaseBundle:UseCase')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new UseCase entity.
     *
     * @Route("/", name="usecase_create")
     * @Method("POST")
     * @Template("FlosyUseCaseBundle:UseCase:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new UseCase();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('usecase_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a UseCase entity.
    *
    * @param UseCase $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(UseCase $entity)
    {
        $form = $this->createForm(new UseCaseType(), $entity, array(
            'action' => $this->generateUrl('usecase_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new UseCase entity.
     *
     * @Route("/new", name="usecase_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UseCase();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a UseCase entity.
     *
     * @Route("/{id}", name="usecase_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FlosyUseCaseBundle:UseCase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UseCase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing UseCase entity.
     *
     * @Route("/{id}/edit", name="usecase_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FlosyUseCaseBundle:UseCase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UseCase entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a UseCase entity.
    *
    * @param UseCase $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(UseCase $entity)
    {
        $form = $this->createForm(new UseCaseType(), $entity, array(
            'action' => $this->generateUrl('usecase_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing UseCase entity.
     *
     * @Route("/{id}", name="usecase_update")
     * @Method("PUT")
     * @Template("FlosyUseCaseBundle:UseCase:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FlosyUseCaseBundle:UseCase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UseCase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('usecase_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a UseCase entity.
     *
     * @Route("/{id}", name="usecase_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FlosyUseCaseBundle:UseCase')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UseCase entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usecase'));
    }

    /**
     * Creates a form to delete a UseCase entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usecase_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

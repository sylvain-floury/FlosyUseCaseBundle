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
     * Finds and displays a UseCase entity.
     *
     * @Route("/{id}/show", name="usecase_show")
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
     * Displays a form to create a new UseCase entity.
     *
     * @Route("/new", name="usecase_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new UseCase();
        $form   = $this->createForm(new UseCaseType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new UseCase entity.
     *
     * @Route("/create", name="usecase_create")
     * @Method("POST")
     * @Template("FlosyUseCaseBundle:UseCase:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new UseCase();
        $form = $this->createForm(new UseCaseType(), $entity);
        $form->bind($request);

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
     * Displays a form to edit an existing UseCase entity.
     *
     * @Route("/{id}/edit", name="usecase_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FlosyUseCaseBundle:UseCase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find UseCase entity.');
        }

        $editForm = $this->createForm(new UseCaseType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing UseCase entity.
     *
     * @Route("/{id}/update", name="usecase_update")
     * @Method("POST")
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
        $editForm = $this->createForm(new UseCaseType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
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
     * @Route("/{id}/delete", name="usecase_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

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

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

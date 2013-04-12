<?php

namespace Flosy\Bundle\UseCaseBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrapView;

use Flosy\Bundle\UseCaseBundle\Entity\UseCase;
use Flosy\Bundle\UseCaseBundle\Form\UseCaseType;
use Flosy\Bundle\UseCaseBundle\Form\UseCaseFilterType;

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
        list($filterForm, $queryBuilder) = $this->filter();

        list($entities, $pagerHtml) = $this->paginator($queryBuilder);

        return array(
            'entities' => $entities,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
        );
    }

    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $filterForm = $this->createForm(new UseCaseFilterType());
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('FlosyUseCaseBundle:UseCase')->createQueryBuilder('e');

        // Reset filter
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'reset') {
            $session->remove('UseCaseControllerFilter');
        }

        // Filter action
        if ($request->getMethod() == 'POST' && $request->get('filter_action') == 'filter') {
            // Bind values from the request
            $filterForm->bind($request);

            if ($filterForm->isValid()) {
                // Build the query from the given form object
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
                // Save filter to session
                $filterData = $filterForm->getData();
                $session->set('UseCaseControllerFilter', $filterData);
            }
        } else {
            // Get filter from session
            if ($session->has('UseCaseControllerFilter')) {
                $filterData = $session->get('UseCaseControllerFilter');
                $filterForm = $this->createForm(new UseCaseFilterType(), $filterData);
                $this->get('lexik_form_filter.query_builder_updater')->addFilterConditions($filterForm, $queryBuilder);
            }
        }

        return array($filterForm, $queryBuilder);
    }

    /**
    * Get results from paginator and get paginator view.
    *
    */
    protected function paginator($queryBuilder)
    {
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $currentPage = $this->getRequest()->get('page', 1);
        $pagerfanta->setCurrentPage($currentPage);
        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me)
        {
            return $me->generateUrl('usecase', array('page' => $page));
        };

        // Paginator - view
        $translator = $this->get('translator');
        $view = new TwitterBootstrapView();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => $translator->trans('views.common.pager.previous', array(), 'FlosyUseCaseBundle'),
            'next_message' => $translator->trans('views.common.pager.next', array(), 'FlosyUseCaseBundle'),
        ));

        return array($entities, $pagerHtml);
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
        $entity  = new UseCase();
        $form = $this->createForm(new UseCaseType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.create.success');

            return $this->redirect($this->generateUrl('usecase_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
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
        $form   = $this->createForm(new UseCaseType(), $entity);

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
        $editForm = $this->createForm(new UseCaseType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.update.success');

            return $this->redirect($this->generateUrl('usecase_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.update.error');
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
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FlosyUseCaseBundle:UseCase')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find UseCase entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'flash.delete.success');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'flash.delete.error');
        }

        return $this->redirect($this->generateUrl('usecase'));
    }

    /**
     * Creates a form to delete a UseCase entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

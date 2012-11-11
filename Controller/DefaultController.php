<?php

namespace Flosy\Bundle\UseCaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Default controller.
 *
 * @Route("/use_case")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="use_case")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('use_case_project'));
    }
}

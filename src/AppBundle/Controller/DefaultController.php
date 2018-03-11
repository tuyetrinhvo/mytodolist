<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $response = $this->render('default/index.html.twig');

        $response->setSharedMaxAge(3600); // cache for 3600 seconds

        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }
}

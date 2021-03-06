<?php

namespace PlaceFinder\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    /**
     * Returns a list of places
     *
     * @return Response
     *
     * @Route("/", name="admin_index")
     */
    public function indexAction()
    {
        return $this->render('PlaceFinderAdminBundle:Default:index.html.twig', array());
    }
}

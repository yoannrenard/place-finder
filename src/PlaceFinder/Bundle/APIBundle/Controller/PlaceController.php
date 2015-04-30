<?php

namespace PlaceFinder\Bundle\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use PlaceFinder\Bundle\DomainBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PlaceController
 *
 * @package PlaceFinder\Bundle\APIBundle\Controller
 */
class PlaceController extends FOSRestController
{
    /**
     * @return Response
     */
    public function getPlacesAction()
    {
        $placeList = $this->container->get('place_finder_domain.manager.place_finder')->getAllFiltered();

        $view = $this->view($placeList, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * @param Place $place
     *
     * @return Response
     */
    public function getPlaceAction(Place $place)
    {
        $view = $this->view($place, Response::HTTP_OK);

        return $this->handleView($view);
    }
}
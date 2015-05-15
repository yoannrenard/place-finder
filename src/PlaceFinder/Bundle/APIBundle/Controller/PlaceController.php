<?php

namespace PlaceFinder\Bundle\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use PlaceFinder\Bundle\DomainBundle\Entity\Place;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PlaceController
 *
 * @package PlaceFinder\Bundle\APIBundle\Controller
 */
class PlaceController extends FOSRestController
{
    /**
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Response
     *
     * @QueryParam(name="online", requirements="(0|1)", description="The results should be online or not")
     */
    public function getPlacesAction(ParamFetcherInterface $paramFetcher)
    {
        $placeList = $this->container->get('place_finder_domain.manager.place_finder')->getAllFiltered($paramFetcher->all());

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

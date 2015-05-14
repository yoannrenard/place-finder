<?php

namespace PlaceFinder\Bundle\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
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
     * Get a list of places
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @return Response
     *
     * @QueryParam(name="online", requirements="(0|1)", description="The results should be online or not")
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get a list of places",
     *  output="Place[]"
     * )
     */
    public function getPlacesAction(ParamFetcherInterface $paramFetcher)
    {
        $placeList = $this->container->get('place_finder_domain.manager.place_finder')->getAllFiltered($paramFetcher->all());

        $view = $this->view($placeList, Response::HTTP_OK);

        return $this->handleView($view);
    }

    /**
     * Get a place
     *
     * @param Place $place
     *
     * @return Response
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get a list of places",
     *  requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="place id"
     *      }
     *  },
     *  parameters={
     *      {"name"="id", "dataType"="integer", "required"=true, "description"="place id"}
     *  },
     *  output="Place"
     * )
     */
    public function getPlaceAction(Place $place)
    {
        $view = $this->view($place, Response::HTTP_OK);

        return $this->handleView($view);
    }
}

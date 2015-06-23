<?php

namespace PlaceFinder\Bundle\APIBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use PlaceFinder\Bundle\DomainBundle\Entity\Place;
use PlaceFinder\Bundle\DomainBundle\Entity\PlaceUpdateProposal;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * Class PlaceController
 *
 * @package PlaceFinder\Bundle\APIBundle\Controller
 */
class PlaceController extends Controller
{
    /**
     * @param json $content
     * @param int  $status
     *
     * @return Response
     */
    protected function jsonResponse($content, $status = Response::HTTP_OK)
    {
        return new Response($content, $status, array('Content-Type' => 'application/json'));
    }

    /**
     * Returns a list of places
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/places", name="api_places_get")
     * @Method("GET")
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get a list of places",
     *  output="Place[]"
     * )
     */
    public function getPlacesAction(Request $request)
    {
        $placeList = $this->container->get('place_finder_domain.manager.place')->getAllFiltered($request->query->all());

        return $this->jsonResponse($this->get('jms_serializer')->serialize($placeList, 'json'));
    }

    /**
     * Returns the place with id of :id
     *
     * @param Place $place
     *
     * @return Response
     *
     * @Route("/places/{id}", name="api_place_get", requirements={"id": "\d+"})
     * @Method("GET")
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
        return $this->jsonResponse($this->get('jms_serializer')->serialize($place, 'json'));
    }

    /**
     * Adds a new place and return it with an id attribute added
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws MethodNotAllowedException
     *
     * @Route("/places", name="api_place_post")
     * @Method("POST")
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get a list of places"
     * )
     */
    public function postPlacesAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');

        $place = $serializer->deserialize($request->getContent(), Place::class, 'json');
        $errors = $this->get('validator')->validate($place);
        if (0 == count($errors)) {
            $this->get('place_finder_domain.manager.place')->save($place);
        } else {
            return $this->jsonResponse(
                $serializer->serialize(array('violations' => $errors), 'json'),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->jsonResponse(
            $serializer->serialize($this->get('place_finder_domain.provider.place')->load($place->getId()), 'json'),
            Response::HTTP_CREATED
        );
    }

    /**
     * Updates the contact with id of :id
     *
     * @param Place   $place
     * @param Request $request
     *
     * @return Response
     *
     * @throws NotFoundHttpException
     * @throws MethodNotAllowedException
     *
     * @Route("/places/{id}", name="api_place_put", requirements={"id": "\d+"})
     * @Method("PUT")
     */
    public function putPlacesAction(Place $place, Request $request)
    {
        throw new AccessDeniedException();

        $serializer = $this->get('jms_serializer');

        $placeUpdated = $serializer->deserialize($request->getContent(), Place::class, 'json');
        if ($place->getId() != $placeUpdated->getId()) {
            throw new NotFoundHttpException(sprintf('The id #%s doesn`t correspond', $placeUpdated->getId()));
        }

        $errors = $this->get('validator')->validate($placeUpdated);
        if (0 == count($errors)) {
            $this->get('place_finder_domain.manager.place')->save($placeUpdated);
        } else {
            return $this->jsonResponse(
                $serializer->serialize(array('violations' => $errors), 'json'),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->jsonResponse(
            $serializer->serialize($this->get('place_finder_domain.provider.place')->load($place->getId()), 'json'),
            Response::HTTP_CREATED
        );
    }

    /**
     * Partially updates the contact with id of :id
     *
     * @param Place   $place
     * @param Request $request
     *
     * @return Response
     *
     * @throws MethodNotAllowedException
     *
     * @Route("/places/{id}", name="api_place_patch", requirements={"id": "\d+"})
     * @Method("PATCH")
     */
    public function patchPlaceAction(Place $place, Request $request)
    {
        /** @var PlaceUpdateProposal $placeUpdateProposal */
        $placeUpdateProposal = $this->get('jms_serializer')->deserialize($request->getContent(), PlaceUpdateProposal::class, 'json');
        $placeUpdateProposal->setPlace($place);

        $errors = $this->get('validator')->validate($placeUpdateProposal);
        if (0 == count($errors)) {
            $this->get('place_finder_domain.manager.place_update_proposal')->save($placeUpdateProposal);
        } else {
            return $this->jsonResponse(
                $this->get('jms_serializer')->serialize(array('violations' => $errors), 'json'),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->jsonResponse('', Response::HTTP_CREATED);
    }

    /**
     * Deletes the contact with id of :id
     *
     * @param Place $place
     *
     * @return Response
     *
     * @Route("/places/{id}", name="api_place_delete", requirements={"id": "\d+"})
     * @Method("DELETE")
     */
    public function deletePlaceAction(Place $place)
    {
        throw new AccessDeniedException();

        $place->softDelete();
        $this->get('place_finder_domain.manager.place')->save($place);

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace PlaceFinder\Bundle\APIBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use PlaceFinder\Bundle\DomainBundle\Entity\Place;
use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PlaceController
 *
 * @package PlaceFinder\Bundle\APIBundle\Controller
 */
class PlaceController extends Controller
{
//URL                           HTTP Method  Operation
///api/contacts                 GET          Returns an array of contacts
///api/contacts/:id             GET          Returns the contact with id of :id
///api/contacts                 POST         Adds a new contact and return it with an id attribute added
///api/contacts/:id             PUT          Updates the contact with id of :id
///api/contacts/:id             PATCH        Partially updates the contact with id of :id
///api/contacts/:id             DELETE       Deletes the contact with id of :id

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

        return new Response($this->get('jms_serializer')->serialize($placeList, 'json'), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * Returns the place with id of :id
     *
     * @param Place $place
     *
     * @return Response
     *
     * @Route("/places/{id}", name="api_place_get",
     *      requirements={
     *         "id": "\d+"
     *     })
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
        return new Response($this->get('jms_serializer')->serialize($place, 'json'), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * Adds a new place and return it with an id attribute added
     *
     * @param Request $request
     *
     * @return Response
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
        $place = new Place();

        return $this->updatePlace($request, $place);
    }

    /**
     * Updates the contact with id of :id
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/places/{id}", name="api_place_put",
     *      requirements={
     *         "id": "\d+"
     *     })
     * @Method("PUT")
     */
    public function putPlacesAction(Place $place, Request $request)
    {
        return $this->updatePlace($request, $place);
    }

    /**
     * Partially updates the contact with id of :id
     *
     * @param Place   $id
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/places/{id}", name="api_place_patch",
     *      requirements={
     *         "id": "\d+"
     *     })
     * @Method("PATCH")
     */
    public function patchPlaceAction(Place $place, Request $request)
    {

        die;
        $place = new Place();



        return $this->updatePlace($request, $place);
    }

//    /**
//     * Deletes the contact with id of :id
//     *
//     * @param Place $place
//     *
//     * @Route("/places/{id}", name="api_place_delete",
//     *      requirements={
//     *         "id": "\d+"
//     *     })
//     * @Method("DELETE")
//     */
//    public function deletePlaceAction(Place $place)
//    {
//        $this->get('place_finder_domain.updater.soft_delete_place')->softDelete($place);
//        $this->get('place_finder_domain.manager.place')->save($place);
//    }
//
    /**
     * @param Request $request
     * @param Place   $place
     *
     * @return Response
     */
    protected function updatePlace(Request $request, Place $place)
    {
        $placeForm = $this->createForm($this->get('place_finder_domain.form.place'), $place);

        if (Request::METHOD_POST === $request->getMethod()) {
            $placeForm->submit($request);
            if ($placeForm->isValid()) {
                return new Response('yes', Response::HTTP_NOT_FOUND);
                $this->get('place_finder_domain.manager.place')->save($place);

                return $this->getPlaceAction($place);
            }
        }

        die('merde');
//        return $this->handleView($this->onCreatePlaceError($placeForm));
    }
//
//    /**
//     * Returns a HTTP_BAD_REQUEST response when the form submission fails.
//     *
//     * @param FormInterface $form
//     *
//     * @return View
//     */
//    protected function onCreatePlaceError(FormInterface $form)
//    {
//        $view = View::create()
//            ->setStatusCode(Codes::HTTP_BAD_REQUEST)
//            ->setData(array(
//                'form' => $form,
//            ))
//            ->setTemplate(new TemplateReference('PlaceFinderAPIBundle', 'Place', 'new'));
//
//        return $view;
//    }
}

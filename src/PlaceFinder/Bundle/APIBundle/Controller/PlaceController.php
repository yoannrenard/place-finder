<?php

namespace PlaceFinder\Bundle\APIBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

/**
 * Class PlaceController
 *
 * @package PlaceFinder\Bundle\APIBundle\Controller
 */
class PlaceController extends FOSRestController
{
    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPlaceAction($id)
    {
        $data = array(
            'toto' => 'tata',
            'tata' => 'titi',
            'id'    => $id,
        );
        $view = $this->view($data, 200);

        return $this->handleView($view);
    }
}

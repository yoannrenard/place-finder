<?php

namespace PlaceFinder\DomainBundle\Provider;

use PlaceFinder\DomainBundle\Exception\PlaceNotFoundException;
use PlaceFinder\DomainBundle\Manager\PlaceManager;

/**
 * Class PlaceProvider
 *
 * @package PlaceFinder\DomainBundle\Provider
 */
class PlaceProvider implements PlaceProviderInterface
{
    /** @var PlaceManager */
    protected $placeManager;

    /**
     * Construct
     *
     * @param PlaceManager $placeManager
     */
    public function __construct(PlaceManager $placeManager)
    {
        $this->placeManager = $placeManager;
    }

    /**
     * @param int $placeId
     *
     * @return Place
     *
     * @throws PlaceNotFoundException
     */
    public function load($placeId)
    {
        $place = $this->placeManager->load($placeId);

        if (null === $place) {
            throw new PlaceNotFoundException(sprintf('The place "%s" doesn\'t exist', $placeId));
        }

        return $place;
    }
}

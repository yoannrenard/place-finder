<?php

namespace PlaceFinder\DomainBundle\Provider;

use PlaceFinder\DomainBundle\Exception\PlaceNotFoundException;

/**
 * Interface PlaceProviderInterface
 *
 * @package PlaceFinder\DomainBundle\Provider
 */
interface PlaceProviderInterface
{
    /**
     * @param int $placeId
     *
     * @return Place
     *
     * @throws PlaceNotFoundException
     */
    public function load($placeId);
}

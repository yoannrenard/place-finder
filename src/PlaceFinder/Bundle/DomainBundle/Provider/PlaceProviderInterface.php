<?php

namespace PlaceFinder\Bundle\DomainBundle\Provider;

use PlaceFinder\Bundle\DomainBundle\Exception\PlaceNotFoundException;

/**
 * Interface PlaceProviderInterface
 *
 * @package PlaceFinder\Bundle\DomainBundle\Provider
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

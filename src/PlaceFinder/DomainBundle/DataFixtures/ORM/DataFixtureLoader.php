<?php

namespace PlaceFinder\DomainBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader as BaseDataFixtureLoader;
use Nelmio\Alice\Fixtures;

/**
 * Class DataFixtureLoader
 *
 * @package PlaceFinder\DomainBundle\DataFixtures\ORM
 */
class DataFixtureLoader extends BaseDataFixtureLoader
{
    const PLACE_DIR = 'Place';

    /**
     * {@inheritDoc}
     */
    protected function getFixtures()
    {
        $placeDir = sprintf('%s%s%s%s', __DIR__, DIRECTORY_SEPARATOR, self::PLACE_DIR, DIRECTORY_SEPARATOR);

        return  array(
            $placeDir . 'place_category.yml',   // no dependency
            $placeDir . 'place.yml',            // no dependency
        );
    }
}

<?php

namespace PlaceFinder\Bundle\DomainBundle\Updater;

use PlaceFinder\Bundle\DomainBundle\Entity\Place;

/**
 * Class SoftDeleterPlaceUpdater
 *
 * @package PlaceFinder\Bundle\DomainBundle\Updater
 */
class SoftDeleterPlaceUpdater
{
    /**
     * @param Place     $place
     * @param \DateTime $deletedAt
     *
     * @return $this
     */
    public function softDelete(Place $place, \DateTime $deletedAt = null)
    {
        $deletedAt = $deletedAt? $deletedAt:new \DateTime();

        $place->setDeletedAt($deletedAt);
        $place->setUpdateDt($deletedAt);
    }
}

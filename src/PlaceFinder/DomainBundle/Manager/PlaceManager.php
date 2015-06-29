<?php

namespace PlaceFinder\DomainBundle\Manager;

use Doctrine\ORM\Tools\Pagination\Paginator;
use PlaceFinder\APIBundle\Filter\PlacesFilter;
use PlaceFinder\DomainBundle\Entity\Place;

/**
 * Class PlaceManager
 *
 * @package PlaceFinder\DomainBundle\Manager
 */
class PlaceManager extends AbstractManager
{
    /**
     * Finds entities by a set of criteria.
     *
     * @param PlacesFilter $placesFilter
     * @param array|null   $orderBy
     * @param int|null     $page
     * @param int|null     $limit
     *
     * @return array
     */
    public function getAllFilteredAndPaginated(PlacesFilter $placesFilter, array $orderBy = null, $page, $limit)
    {
        $offset = ($page * $limit) - $limit;

        return new Paginator($this->repository->getAllFiltered($placesFilter, $orderBy, $limit, $offset));
    }

    /**
     * @param Place $place
     */
    public function save(Place $place)
    {
        $this->entityManager->persist($place);
        $this->entityManager->flush($place);
    }
}

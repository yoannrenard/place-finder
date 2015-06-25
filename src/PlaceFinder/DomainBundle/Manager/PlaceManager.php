<?php

namespace PlaceFinder\DomainBundle\Manager;

use Doctrine\ORM\Tools\Pagination\Paginator;
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
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return array
     */
    public function getAllFilteredAndPaginated(array $criteria = array(), array $orderBy = null, $limit = null, $offset = null)
    {
        return new Paginator($this->repository->getAllFiltered($criteria, $orderBy, $limit, $offset));
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

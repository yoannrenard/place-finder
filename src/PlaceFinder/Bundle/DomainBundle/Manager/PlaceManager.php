<?php

namespace PlaceFinder\Bundle\DomainBundle\Manager;

/**
 * Class PlaceManager
 *
 * @package PlaceFinder\Bundle\DomainBundle\Manager
 */
class PlaceManager extends AbstractManager
{
    /**
     * @param array $criteria
     *
     * @return array
     */
    public function getAllFiltered(array $criteria = array())
    {
        $qb = $this->entityManager
            ->createQueryBuilder('p')
            ->select('p')
            ->from($this->class, 'p')
            ->innerJoin('p.placeCategories', 'pc');

        if ('' != $criteria['online']) {
            $qb->where('p.isOnline = :isOnline')
                ->setParameter('isOnline', (boolean) $criteria['online']);
        }

        return $qb->getQuery()
            ->getResult();
    }
}

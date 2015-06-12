<?php

namespace PlaceFinder\Bundle\DomainBundle\Manager;

use PlaceFinder\Bundle\DomainBundle\Entity\Place;

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

        // Online
        if (isset($criteria['is_online']) && '' != $criteria['is_online']) {
            $qb->andWhere('p.isOnline = :isOnline')
                ->setParameter('isOnline', (boolean) $criteria['is_online']);
        } else {
            $qb->andWhere('p.isOnline = :isOnline')
                ->setParameter('isOnline', true);
        }

        return $qb->getQuery()
            ->getResult();
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

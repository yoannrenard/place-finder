<?php

namespace PlaceFinder\Bundle\DomainBundle\Manager;

use PlaceFinder\Bundle\DomainBundle\Entity\PlaceUpdateProposal;

/**
 * Class PlaceUpdateProposalManager
 *
 * @package PlaceFinder\Bundle\DomainBundle\Manager
 */
class PlaceUpdateProposalManager extends AbstractManager
{
    /**
     * @param PlaceUpdateProposal $placeUpdateProposal
     */
    public function save(PlaceUpdateProposal $placeUpdateProposal)
    {
        $this->entityManager->persist($placeUpdateProposal);
        $this->entityManager->flush($placeUpdateProposal);
    }
}

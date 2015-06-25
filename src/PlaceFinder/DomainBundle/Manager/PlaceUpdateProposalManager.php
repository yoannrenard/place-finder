<?php

namespace PlaceFinder\DomainBundle\Manager;

use PlaceFinder\DomainBundle\Entity\PlaceUpdateProposal;

/**
 * Class PlaceUpdateProposalManager
 *
 * @package PlaceFinder\DomainBundle\Manager
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

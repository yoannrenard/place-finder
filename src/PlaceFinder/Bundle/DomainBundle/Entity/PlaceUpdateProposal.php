<?php

namespace PlaceFinder\Bundle\DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlaceUpdateProposal
 *
 * @ORM\Table("place_update_proposal")
 * @ORM\Entity
 */
class PlaceUpdateProposal extends UpdateProposal
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Place $place
     *
     * @ORM\ManyToOne(targetEntity="Place", inversedBy="placeUpdateProposals")
     * @ORM\JoinColumn(name="place_id", referencedColumnName="id")
     **/
    protected $place;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Place $place
     *
     * @return this
     */
    public function setPlace(Place $place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Place
     */
    public function getPlace()
    {
        return $this->place;
    }
}

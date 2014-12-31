<?php

namespace PlaceFinder\Bundle\DomainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PlaceFinder\Bundle\DomainBundle\Entity\Place;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PlaceCategory
 *
 * @ORM\Table(name="place_category")
 * @ORM\Entity(repositoryClass="PlaceFinder\Bundle\DomainBundle\Repository\PlaceCategoryRepository")
 */
class PlaceCategory
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50)
     *
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Place", mappedBy="placeCategories")
     **/
    protected $places;


    /**
     * Construct
     */
    public function __construct()
    {
        $this->places = new ArrayCollection();
    }

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}

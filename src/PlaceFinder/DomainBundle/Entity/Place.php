<?php

namespace PlaceFinder\DomainBundle\Entity;

use \DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use PlaceFinder\DomainBundle\Entity\PlaceCategory;

/**
 * Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="PlaceFinder\DomainBundle\Repository\PlaceRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deleted_at", timeAware=false)
 */
class Place
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
     * @var DateTime
     *
     * @ORM\Column(name="create_dt", type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    protected $createDt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="update_dt", type="datetime")
     *
     * @Gedmo\Timestampable(on="update")
     */
    protected $updateDt;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=75)
     *
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var decimal
     *
     * @ORM\Column(name="latitude", type="decimal", scale=8)
     *
     * @Assert\NotBlank()
     */
    protected $latitude;

    /**
     * @var decimal
     *
     * @ORM\Column(name="longitude", type="decimal", scale=8)
     *
     * @Assert\NotBlank()
     */
    protected $longitude;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_online", type="boolean", options={"default"=false})
     */
    protected $isOnline = false;

    /**
     * @var PlaceCategory[]
     *
     * @ORM\ManyToMany(targetEntity="PlaceCategory", inversedBy="places")
     * @ORM\JoinTable(name="place_categories")
     **/
    protected $placeCategories;

    /**
     * @var PlaceUpdateProposal $placeUpdateProposals
     *
     * @ORM\OneToMany(targetEntity="PlaceUpdateProposal", mappedBy="place")
     */
    protected $placeUpdateProposals;

    /**
     * Construct
     */
    public function __construct()
    {
        $this->placeCategories      = new ArrayCollection();
        $this->placeUpdateProposals = new ArrayCollection();
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
     * @return DateTime
     */
    public function getCreateDt()
    {
        return $this->createDt;
    }

    /**
     * @param DateTime $createDt
     *
     * @return $this
     */
    public function setCreateDt(DateTime $createDt = null)
    {
        $this->createDt = $createDt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdateDt()
    {
        return $this->updateDt;
    }

    /**
     * @param DateTime $updateDt
     *
     * @return $this
     */
    public function setUpdateDt(DateTime $updateDt = null)
    {
        $this->updateDt = $updateDt;

        return $this;
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

    /**
     * @return decimal
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param decimal $latitude
     *
     * @return $this
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return decimal
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param decimal $longitude
     *
     * @return $this
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param DateTime $deletedAt
     *
     * @return $this
     */
    public function setDeletedAt(DateTime $deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isIsOnline()
    {
        return $this->isOnline;
    }

    /**
     * @param boolean $isOnline
     *
     * @return $this
     */
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    /**
     * @param PlaceUpdateProposal $placeUpdateProposals
     *
     * @return $this
     */
    public function setPlaceUpdateProposals(PlaceUpdateProposal $placeUpdateProposals)
    {
        $this->placeUpdateProposals = $placeUpdateProposals;

        return $this;
    }

    /**
     * @return PlaceUpdateProposal
     */
    public function getPlaceUpdateProposals()
    {
        return $this->placeUpdateProposals;
    }

    /**
     * @param PlaceCategory[] $placeCategories
     *
     * @return $this
     */
    public function setPlaceCategories($placeCategories)
    {
        $this->placeCategories = $placeCategories;

        return $this;
    }

    /**
     * @param PlaceCategory $placeCategory
     *
     * @return $this
     */
    public function addPlaceCategory(PlaceCategory $placeCategory)
    {
        $this->placeCategories->add($placeCategory);

        return $this;
    }

    /**
     * @return PlaceCategory
     */
    public function getPlaceCategories()
    {
        return $this->placeCategories;
    }

    /**
     * @param \DateTime $deletedAt
     *
     * @return $this
     */
    public function softDelete(\DateTime $deletedAt = null)
    {
        $deletedAt = $deletedAt? $deletedAt:new \DateTime();

        $this->setDeletedAt($deletedAt);
        $this->setUpdateDt($deletedAt);

        return $this;
    }
}

<?php

namespace PlaceFinder\Bundle\DomainBundle\Entity;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Place
 *
 * @ORM\Table(name="place")
 * @ORM\Entity(repositoryClass="PlaceFinder\Bundle\DomainBundle\Entity\PlaceRepository")
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
    protected $isOnline;


    /**
     * Construct
     */
    public function __construct()
    {
        $this->isOnline = false;
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
    public function setCreateDt(DateTime $createDt)
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
    public function setUpdateDt(DateTime $updateDt)
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
     */
    public function setDeletedAt(DateTime $deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }
}

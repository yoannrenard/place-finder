<?php

namespace PlaceFinder\Bundle\DomainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OpeningTime
 *
 * @ORM\Table(name="opening_time")
 * @ORM\Entity(repositoryClass="PlaceFinder\Bundle\DomainBundle\Entity\OpeningTimeRepository")
 */
class OpeningTime
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
     * @var Time
     *
     * @ORM\Column(name="open", type="time")
     *
     * @Assert\NotBlank()
     */
    protected $open;

    /**
     * @var Time
     *
     * @ORM\Column(name="close", type="time")
     *
     * @Assert\NotBlank()
     */
    protected $close;

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
     * @return Time
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * @param Time $open
     *
     * @return $this
     */
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * @return Time
     */
    public function getClose()
    {
        return $this->close;
    }

    /**
     * @param Time $close
     *
     * @return $this
     */
    public function setClose($close)
    {
        $this->close = $close;

        return $this;
    }
}

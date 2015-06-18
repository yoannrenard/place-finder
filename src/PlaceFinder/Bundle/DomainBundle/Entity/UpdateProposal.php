<?php

namespace PlaceFinder\Bundle\DomainBundle\Entity;

use \DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UpdateProposal
 *
 * @package PlaceFinder\Bundle\DomainBundle\Entity
 *
 * @ORM\MappedSuperclass
 */
abstract class UpdateProposal
{
    const OPERATION_REMOVE  = 'remove';
    const OPERATION_ADD     = 'add';
    const OPERATION_REPLACE = 'replace';
    const OPERATION_MOVE    = 'move';
    const OPERATION_COPY    = 'copy';

    const STATUS_NEW        = 'new';
    const STATUS_REJECTED   = 'rejected';
    const STATUS_APPLIED    = 'applied';

    /**
     * @var string $operation
     *
     * @ORM\Column(name="operation", type="string", columnDefinition="ENUM('remove', 'add', 'replace', 'move', 'copy')")
     *
     * @Assert\NotBlank()
     */
    protected $operation;

    /**
     * @var string $field
     *
     * @ORM\Column(name="field", type="string", length=50)
     *
     * @Assert\NotBlank()
     */
    protected $field;

    /**
     * @var string $value
     *
     * @ORM\Column(name="value", type="string", length=255)
     *
     * @Assert\NotBlank()
     */
    protected $value;

    /**
     * @var DateTime $createDt
     *
     * @ORM\Column(name="create_dt", type="datetime")
     *
     * @Gedmo\Timestampable(on="create")
     */
    protected $createDt;

    /**
     * @var DateTime $appliedDt
     *
     * @ORM\Column(name="appliedDt", type="datetime", nullable=true)
     */
    protected $appliedDt;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", columnDefinition="ENUM('new', 'rejected', 'applied')")
     */
    protected $status = self::STATUS_NEW;

    /**
     * @param \DateTime $createDt
     *
     * @return this
     */
    public function setCreateDt(DateTime $createDt)
    {
        $this->createDt = $createDt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreateDt()
    {
        return $this->createDt;
    }

    /**
     * @param string $field
     *
     * @return this
     */
    public function setField($field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $operation
     *
     * @return this
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * @param string $value
     *
     * @return this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param DateTime $appliedDt
     *
     * @return this
     */
    public function setAppliedDt(DateTime $appliedDt = null)
    {
        $this->appliedDt = $appliedDt;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getAppliedDt()
    {
        return $this->appliedDt;
    }

    /**
     * @param mixed $status
     *
     * @return this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }
}

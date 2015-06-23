<?php

namespace PlaceFinder\Bundle\DomainBundle\Tests\Entity;

use PlaceFinder\Bundle\DomainBundle\Entity\Place;

/**
 * Class PlaceTest
 *
 * @package PlaceFinder\Bundle\DomainBundle\Tests\Entity
 */
class PlaceTest extends \PHPUnit_Framework_TestCase
{
    /** @var Place */
    protected $place;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->place = new Place();
    }

    /**
     * @return array
     */
    public function softDeleteDataProvider()
    {
        $updateDt = new \DateTime();

        $expectedPlace = new Place();
        $expectedPlace->setDeletedAt($updateDt);
        $expectedPlace->setUpdateDt($updateDt);

        return array(
            array($updateDt, $expectedPlace),
        );
    }

    /**
     * @param \DateTime $updateDt
     * @param Place     $expectedPlace
     *
     * @dataProvider softDeleteDataProvider
     */
    public function testSoftDelete(\DateTime $updateDt, Place $expectedPlace)
    {
        $this->place->softDelete($updateDt);

        $this->assertEquals($expectedPlace, $this->place);
    }
}

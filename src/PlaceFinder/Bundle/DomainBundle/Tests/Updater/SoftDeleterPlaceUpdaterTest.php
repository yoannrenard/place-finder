<?php

namespace PlaceFinder\Bundle\DomainBundle\Tests\Updater;

use PlaceFinder\Bundle\DomainBundle\Entity\Place;
use PlaceFinder\Bundle\DomainBundle\Updater\SoftDeleterPlaceUpdater;

/**
 * Class SoftDeleterPlaceUpdaterTest
 *
 * @package PlaceFinder\Bundle\DomainBundle\Tests
 */
class SoftDeleterPlaceUpdaterTest extends \PHPUnit_Framework_TestCase
{
    /** @var SoftDeleterPlaceUpdaterTest */
    protected $softDeleterPlaceUpdater;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->softDeleterPlaceUpdater = new SoftDeleterPlaceUpdater();
    }

    /**
     * @return array
     */
    public function softDeleteDataProvider()
    {
        $updateDt = new \DateTime();

        $place         = new Place();
        $expectedPlace = new Place();
        $expectedPlace->setDeletedAt($updateDt);
        $expectedPlace->setUpdateDt($updateDt);

        return array(
            array($place, $updateDt, $expectedPlace),
        );
    }

    /**
     * @param Place     $place
     * @param \DateTime $updateDt
     * @param Place     $expectedPlace
     *
     * @dataProvider softDeleteDataProvider
     */
    public function testSoftDelete(Place $place, \DateTime $updateDt, Place $expectedPlace)
    {
        $this->softDeleterPlaceUpdater->softDelete($place, $updateDt);

        $this->assertEquals($expectedPlace, $place);
    }
}

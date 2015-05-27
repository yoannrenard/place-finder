<?php

namespace PlaceFinder\Bundle\DomainBundle\Tests\Provider;

use Phake;
use PlaceFinder\Bundle\DomainBundle\Entity\Place;
use PlaceFinder\Bundle\DomainBundle\Exception\PlaceNotFoundException;
use PlaceFinder\Bundle\DomainBundle\Manager\PlaceManager;
use PlaceFinder\Bundle\DomainBundle\Provider\PlaceProvider;

/**
 * Class PlaceProviderTest
 *
 * @package PlaceFinder\Bundle\DomainBundle\Tests\Provider
 */
class PlaceProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var PlaceProvider */
    protected $placeProvider;

    /** @var PlaceManager */
    protected $placeManagerMock;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->placeManagerMock = Phake::mock(PlaceManager::class);

        $this->placeProvider = new PlaceProvider($this->placeManagerMock);
    }

    /**
     * @return array
     */
    public function loadDataProvider()
    {
        return array(
            array(new Place(), new Place()),
            array(null,        null),
        );
    }

    /**
     * @param Place $place
     * @param Place $expectedResult
     *
     * @dataProvider loadDataProvider
     */
    public function testLoad($place, $expectedResult)
    {
        Phake::when($this->placeManagerMock)->load(Phake::anyParameters())->thenReturn($place);

        if (null === $expectedResult) {
            $this->setExpectedException(PlaceNotFoundException::class);
        }

        $this->assertEquals($place, $expectedResult);
        $this->placeProvider->load(1);
    }
}

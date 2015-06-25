<?php

namespace PlaceFinder\DomainBundle\Tests\Provider;

use Phake;
use PlaceFinder\DomainBundle\Entity\Place;
use PlaceFinder\DomainBundle\Exception\PlaceNotFoundException;
use PlaceFinder\DomainBundle\Manager\PlaceManager;
use PlaceFinder\DomainBundle\Provider\PlaceProvider;

/**
 * Class PlaceProviderTest
 *
 * @package PlaceFinder\DomainBundle\Tests\Provider
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

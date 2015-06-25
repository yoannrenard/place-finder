<?php

namespace PlaceFinder\APIBundle\Tests\Builder;

use Phake;
use PlaceFinder\APIBundle\Builder\HttpHeaderLinkBuilder;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class HttpHeaderLinkBuilderTest
 *
 * @package PlaceFinder\APIBundle\Tests\Builder
 */
class HttpHeaderLinkBuilderTest extends \PHPUnit_Framework_TestCase
{
    const URL_PATTERN = 'MY_URL?page=%s';
    const ROUTE         = 'api_places_get';

    /** @var HttpHeaderLinkBuilder */
    protected $httpHeaderLinkBuilder;

    /** @var Router */
    protected $routerMock;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->routerMock = Phake::mock(Router::class);

        $this->httpHeaderLinkBuilder = new HttpHeaderLinkBuilder($this->routerMock);
    }

    /**
     * @return array
     */
    public function buildDataProvider()
    {
        return array(
            array(150, 15, 1),
            array(150, 15, 2),
            array(150, 15, 3),
            array(150, 15, 4),
            array(150, 15, 10),
        );
    }

    /**
     * @param int $nbResult
     * @param int $limit
     * @param int $page
     *
     * @dataProvider buildDataProvider
     */
    public function testBuild($nbResult, $limit, $page)
    {
        $lastPage      = ceil($nbResult / $limit);
        $previousPage  = $page>1? $page-1:1;
        $nextPage      = $page<$lastPage? $page+1:$lastPage;

        $expectedLinks = array(
            sprintf('<%s>; rel="%s"', self::URL_PATTERN.'1',            'first'),
            sprintf('<%s>; rel="%s"', self::URL_PATTERN.$previousPage, 'prev'),
            sprintf('<%s>; rel="%s"', self::URL_PATTERN.$nextPage,     'next'),
            sprintf('<%s>; rel="%s"', self::URL_PATTERN.$lastPage,     'last'),
        );

        Phake::when($this->routerMock)->generate(self::ROUTE, array('page' => 1), true)            ->thenReturn(self::URL_PATTERN.'1');
        Phake::when($this->routerMock)->generate(self::ROUTE, array('page' => $previousPage), true)->thenReturn(self::URL_PATTERN.$previousPage);
        Phake::when($this->routerMock)->generate(self::ROUTE, array('page' => $nextPage), true)    ->thenReturn(self::URL_PATTERN.$nextPage);
        Phake::when($this->routerMock)->generate(self::ROUTE, array('page' => $lastPage), true)    ->thenReturn(self::URL_PATTERN.$lastPage);

        $this->assertEquals($expectedLinks, $this->httpHeaderLinkBuilder->build(self::ROUTE, $nbResult, $page, $limit));
    }
}

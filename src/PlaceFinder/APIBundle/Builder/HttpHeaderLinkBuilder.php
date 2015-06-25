<?php

namespace PlaceFinder\APIBundle\Builder;

use Symfony\Component\Routing\RouterInterface;

/**
 * Class HttpHeaderLinkBuilder
 *
 * @package PlaceFinder\APIBundle\Builder
 */
class HttpHeaderLinkBuilder implements HttpHeaderLinkBuilderInterface
{
    const LINK_PATTERN = '<%s>; rel="%s"';

    /** @var RouterInterface */
    protected $router;

    /**
     * Construct
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public function build($route, $nbResult, $page, $limit)
    {
        $lastPage      = ceil($nbResult / $limit);
        $previousPage  = $page>1? $page-1:1;
        $nextPage      = $page<$lastPage? $page+1:$lastPage;

        $links = array(
            sprintf(self::LINK_PATTERN, $this->router->generate($route, array('page' => 1), true),             'first'),
            sprintf(self::LINK_PATTERN, $this->router->generate($route, array('page' => $previousPage), true), 'prev'),
            sprintf(self::LINK_PATTERN, $this->router->generate($route, array('page' => $nextPage), true),     'next'),
            sprintf(self::LINK_PATTERN, $this->router->generate($route, array('page' => $lastPage), true),     'last'),
        );

        return $links;
    }
}

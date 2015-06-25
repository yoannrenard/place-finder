<?php

namespace PlaceFinder\APIBundle\Builder;

/**
 * Interface HttpHeaderLinkBuilderInterface
 *
 * @package PlaceFinder\APIBundle\Builder
 */
interface HttpHeaderLinkBuilderInterface
{
    /**
     * Return an array of Headers Links
     *
     * @param string $route
     * @param int    $nbResult
     * @param int    $page
     * @param int    $limit
     *
     * @return array
     */
    public function build($route, $nbResult, $page, $limit);
}

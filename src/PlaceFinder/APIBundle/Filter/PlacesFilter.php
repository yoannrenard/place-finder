<?php

namespace PlaceFinder\APIBundle\Filter;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PlacesFilter
 *
 * @package PlaceFinder\APIBundle\Filter
 */
class PlacesFilter
{
    /**
     * @var bool
     */
    protected $isOnline;

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var int
     */
    protected $perPage = 15;

    /**
     * @param bool $isOnline
     *
     * @return this
     */
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsOnline()
    {
        return $this->isOnline;
    }

    /**
     * @param int $page
     * @param int $default
     *
     * @return this
     */
    public function setPage($page, $default = null)
    {
        if (null !== $page) {
            $this->page = $page;
        } else {
            $this->page = $default;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int $perPage
     * @param int $default
     *
     * @return this
     */
    public function setPerPage($perPage, $default = null)
    {
        if (null !== $perPage) {
            $this->perPage = $perPage;
        } else {
            $this->perPage = $default;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }
}

<?php

namespace yoannrenard\Bundle\HttpPatcherBundle\Tests\Fixtures;

/**
 * Class DummyObject
 *
 * @package yoannrenard\Bundle\HttpPatcherBundle\Tests\Fixtures
 */
class DummyChildObject
{
    protected $id;
    protected $name;
    protected $description;

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

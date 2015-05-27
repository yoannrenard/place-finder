<?php

namespace yoannrenard\Bundle\HttpPatcherBundle\Tests\Fixtures;

/**
 * Class DummyObject
 *
 * @package yoannrenard\Bundle\HttpPatcherBundle\Tests\Fixtures
 */
class DummyObject
{
    protected $id;
    protected $name;
    protected $description;
    protected $dummyObject;

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

    public function setDummyObject(DummyChildObject $dummyObject)
    {
        $this->dummyObject = $dummyObject;
    }

    public function getDummyObject()
    {
        return $this->dummyObject;
    }
}

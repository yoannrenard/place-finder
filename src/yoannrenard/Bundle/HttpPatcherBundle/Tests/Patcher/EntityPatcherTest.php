<?php

namespace yoannrenard\Bundle\HttpPatcherBundle\Tests\Patcher;

use yoannrenard\Bundle\HttpPatcherBundle\Patcher\EntityPatcher;
use yoannrenard\Bundle\HttpPatcherBundle\Tests\Fixtures\DummyChildObject;
use yoannrenard\Bundle\HttpPatcherBundle\Tests\Fixtures\DummyObject;

/**
 * Class EntityPatcherTest
 *
 * @package yoannrenard\Bundle\HttpPatcherBundle\Tests\Patcher
 */
class EntityPatcherTest extends \PHPUnit_Framework_TestCase
{
    /** @var EntityPatcher */
    protected $entityPatcher;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->entityPatcher = new EntityPatcher();
    }

    public function testUpdateSimpleReplace()
    {
        $object = new DummyObject();
        $object->setId(1);
        $object->setName('Dummy');
        $object->setDescription('Dummy Object');

        $parameters = array(
            array(
                'op'    => 'replace',
                'path'  => '/name',
                'value' => 'Dummy Updated',
            )
        );

        $expectedObject = new DummyObject();
        $expectedObject->setId(1);
        $expectedObject->setName('Dummy Updated');
        $expectedObject->setDescription('Dummy Object');

        $this->assertEquals($expectedObject, $this->entityPatcher->update($object, $parameters));
    }

    public function testUpdateSimpleReplaceWithEmptyOperation()
    {
        $parameters = array(
            array(
                'op'    => '',
                'path'  => '/name',
                'value' => '',
            )
        );

        $this->setExpectedException('yoannrenard\Bundle\HttpPatcherBundle\Exception\InvalidOperationException');

        $this->entityPatcher->update(new DummyObject(), $parameters);
    }

    public function testUpdateSimpleReplaceWithoutOperation()
    {
        $parameters = array(
            array(
                'path'  => '/name',
                'value' => '',
            )
        );

        $this->setExpectedException('yoannrenard\Bundle\HttpPatcherBundle\Exception\InvalidOperationException');

        $this->entityPatcher->update(new DummyObject(), $parameters);
    }

    public function testUpdateSimpleReplaceWithEmptyValue()
    {
        $object = new DummyObject();
        $object->setId(1);
        $object->setName('Dummy');
        $object->setDescription('Dummy Object');

        $parameters = array(
            array(
                'op'    => 'replace',
                'path'  => '/name',
                'value' => '',
            )
        );

        $expectedObject = new DummyObject();
        $expectedObject->setId(1);
        $expectedObject->setName('');
        $expectedObject->setDescription('Dummy Object');

        $this->assertEquals($expectedObject, $this->entityPatcher->update($object, $parameters));
    }

    public function testUpdateSimpleReplaceWithoutValue()
    {
        $object = new DummyObject();

        $parameters = array(
            array(
                'op'    => 'replace',
                'path'  => '/name',
            )
        );

        $this->setExpectedException('yoannrenard\Bundle\HttpPatcherBundle\Exception\InvalidValueException');

        $this->entityPatcher->update($object, $parameters);
    }

    public function testUpdateSimpleReplaceWithUnvalidPath()
    {
        $parameters = array(
            array(
                'op'    => 'replace',
                'path'  => 'name2',
                'value' => 'dummy',
            )
        );

        $this->setExpectedException('yoannrenard\Bundle\HttpPatcherBundle\Exception\InvalidPropertyException');

        $this->entityPatcher->update(new DummyObject(), $parameters);
    }

//    public function testUpdateChildReplace()
//    {
//        $childObject = new DummyChildObject();
//        $childObject->getName('toto');
//
//        $object = new DummyObject();
//        $object->setId(1);
//        $object->setName('Dummy');
//        $object->setDescription('Dummy Object');
//        $object->setDummyObject($childObject);
//
//        $parameters = array(
//            array(
//                'op'    => 'replace',
//                'path'  => '/dummyObject/name',
//                'value' => 'titi',
//            )
//        );
//
//        $expectedChildObject = new DummyChildObject();
//        $childObject->getName('titi');
//
//        $expectedObject = new DummyObject();
//        $expectedObject->setId(1);
//        $expectedObject->setName('');
//        $expectedObject->setDescription('Dummy Object');
//        $expectedObject->setDummyObject($childObject);
//
//        $this->assertEquals($expectedObject, $this->entityPatcher->update($object, $parameters));
//    }
}

<?php

namespace yoannrenard\Bundle\HttpPatcherBundle\Patcher;

use yoannrenard\Bundle\HttpPatcherBundle\Exception\InvalidOperationException;
use yoannrenard\Bundle\HttpPatcherBundle\Exception\InvalidPropertyException;
use yoannrenard\Bundle\HttpPatcherBundle\Exception\InvalidValueException;

/**
 * Class EntityPatcher
 *
 * cf: http://williamdurand.fr/2014/02/14/please-do-not-patch-like-an-idiot/
 *
 * @package yoannrenard\Bundle\HttpPatcherBundle\Patcher
 */
class EntityPatcher
{
    const OP_ADD     = 'add';
    const OP_REPLACE = 'replace';
    const OP_REMOVE  = 'remove';
    const OP_MOVE    = 'move';
    const OP_COPY    = 'copy';

    public static $supportedOpList = array(
        self::OP_REPLACE,
    );

//    { "op": "remove", "path": "/a/b/c" },
//    { "op": "add", "path": "/a/b/c", "value": [ "foo", "bar" ] },
//    { "op": "replace", "path": "/a/b/c", "value": 42 },
//    { "op": "move", "from": "/a/b/c", "path": "/a/b/d" },
//    { "op": "copy", "from": "/a/b/d", "path": "/a/b/e" }

    /**
     * @param Object $entity
     * @param array  $parameters
     *
     * @return Object
     *
     * @throws InvalidOperationException
     * @throws InvalidValueException
     */
    public function update($entity, array $parameters = array())
    {
        foreach ($parameters as $parameter) {
            if (!isset($parameter['op']) or empty($parameter['op'])) {
                throw new InvalidOperationException('You must specify witch operation you want to use');
            }

            if (!in_array($parameter['op'], self::$supportedOpList)) {
                throw new InvalidOperationException(sprintf('The operation "%s" isn\'t supported', $parameter['op']));
            }

//            var_dump($parameter);

            switch ($parameter['op']) {
                case self::OP_REPLACE:
                    if (!isset($parameter['value'])) {
                        throw new InvalidValueException(sprintf('The op "%s" isn\'t supported', $parameter['op']));
                    }

                    $properties = explode('/', $parameter['path']);
                    foreach ($properties as $property) {
                        if (!empty($property)) {
                            $method = $this->getMethod($entity, $property);
                            $entity->$method($parameter['value']);
                        }
                    }
                    break;
            }

//            var_dump($properties);

//            $entity->$parameter['path'] = $parameter['value'];
        }

        return $entity;
    }

    public function getMethod($object, $property)
    {
        if (method_exists($object, sprintf('set%s', ucfirst($property)))) {
            return sprintf('set%s', ucfirst($property));
        }

        if (property_exists($object, $property)) {
            return $property;
        }

        throw new InvalidPropertyException(sprintf('The property "%s" doesn\'t exist', $property));
    }
}

<?php

namespace yoannrenard\Bundle\HttpPatcherBundle\Delegate;

/**
 * Class AbstractOperationDelegate
 *
 * @package yoannrenard\Bundle\HttpPatcherBundle\Delegate
 */
abstract class AbstractOperationDelegate
{
    /**
     * @param Object $entity
     * @param array  $parameter
     *
     * @return Object
     */
    public abstract function run($entity, array $parameter = array());
}

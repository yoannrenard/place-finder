<?php

namespace yoannrenard\Bundle\HttpPatcherBundle\Delegate;

/**
 * Class ReplaceOperationDelegate
 *
 * @package yoannrenard\Bundle\HttpPatcherBundle\Delegate
 */
class ReplaceOperationDelegate extends AbstractOperationDelegate
{
    /**
     * {@inheritdoc}
     */
    public function run($entity, array $parameter = array())
    {
        if (!isset($parameter['value'])) {
            throw new InvalidValueException(sprintf('The op "%s" isn\'t supported yet', $parameter['op']));
        }

        $properties = explode('/', $parameter['path']);
        foreach ($properties as $property) {
            if (!empty($property)) {
                $method = $this->getMethod($entity, $property);
                $entity->$method($parameter['value']);
            }
        }

        return $entity;
    }
}

<?php

namespace Context;

use Behat\Behat\Context\BehatContext;
use Guzzle\Service\Client;

/**
 * Feature context.
 */
class FeatureContext extends BehatContext
{
    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->useContext('RestContext', new RestContext($parameters, Client::factory(array('base_url' => $parameters['base_url']))));
    }
}

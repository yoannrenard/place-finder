<?php

namespace Context;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Guzzle\Service\Client;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends BehatContext
{
    /** @var array */
    protected $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;

        $this->useContext('RestContext', new RestContext($parameters, Client::factory(array('base_url' => $this->getParameter('base_url')))));
    }

    /**
     * @param string $parameterName
     *
     * @return null
     *
     * @throws \Exception
     */
    public function getParameter($parameterName)
    {
        if (count($this->parameters) === 0) {
            throw new \Exception('Parameters not loaded!');
        } else {
            return (isset($this->parameters[$parameterName]))? $this->parameters[$parameterName]:null;
        }
    }
}

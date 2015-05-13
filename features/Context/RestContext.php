<?php

namespace Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Exception;
use Guzzle\Http\ClientInterface;

/**
 * Class RestContext
 *
 * @package Context
 */
class RestContext extends BehatContext
{
    /** @var null|\stdClass */
    protected $restObject;

    /** @var \Guzzle\Http\ClientInterface */
    protected $client;

    /** @var \Guzzle\Http\Message\Response */
    protected $response;

    /** @var string */
    protected $requestUrl;

    /** @var array */
    protected $parameters;

    /** @var array */
    protected $responseBody;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array           $parameters
     * @param ClientInterface $client
     */
    public function __construct(array $parameters, ClientInterface $client)
    {
        $this->restObject = new \stdClass();
        $this->parameters = $parameters;
        $this->client     = $client;
    }

    /**
     * @param string $parameterName
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function getParameter($parameterName)
    {
        if (count($this->parameters) === 0) {
            throw new Exception('Parameters not loaded!');
        } else {
            return isset($this->parameters[$parameterName])? $this->parameters[$parameterName]:null;
        }
    }

    protected function getRestObjectFromObjectType($objectType)
    {
        return sprintf('%ss', strtolower($objectType));
    }

    /**
     * @Given /^that I want to find the "([^"]*)" identified by "([^"]*)"$/
     */
    public function thatIWantToFindTheIdentifiedBy($objectType, $id)
    {
        $this->iRequest(sprintf('%s/%d', $this->getRestObjectFromObjectType($objectType), $id), 'GET');
    }

    /**
     * @Given /^that I want to find a "([^"]*)" with:$/
     */
    public function thatIWantToFindA($objectType, TableNode $table)
    {
        $this->iRequest(sprintf('%s', $this->getRestObjectFromObjectType($objectType)), 'GET');
    }

//    /**
//     * @Given /^that I want to make a new "([^"]*)"$/
//     */
//    public function thatIWantToMakeANew($objectType)
//    {
//        $this->restObjectType   = ucwords(strtolower($objectType));
//        $this->restObjectMethod = 'post';
//    }
//
//    /**
//     * @Given /^that I want to find a "([^"]*)"$/
//     */
//    public function thatIWantToFindA($objectType)
//    {
//        $this->restObjectType   = ucwords(strtolower($objectType));
//        $this->restObjectMethod = 'get';
//    }
//
//    /**
//     * @Given /^that I want to delete a "([^"]*)"$/
//     */
//    public function thatIWantToDeleteA($objectType)
//    {
//        $this->restObjectType   = ucwords(strtolower($objectType));
//        $this->restObjectMethod = 'delete';
//    }

    protected function getFormattedRequestUrlWithParams()
    {
        if (!empty($this->restObject)) {
            return $this->requestUrl.'?'.http_build_query((array) $this->restObject);
        }

        return $this->requestUrl;
    }

    /**
     * @When /^I request "([^"]*)"$/
     */
    public function iRequest($pageUrl, $method = 'GET')
    {
        $this->requestUrl = $pageUrl;

        switch ($method) {
            case 'GET':
                $request = $this->client->get($this->getFormattedRequestUrlWithParams());
                break;
            case 'POST':
                $request = $this->client->post($this->requestUrl, null, (array) $this->restObject);
                break;
            case 'DELETE':
                $request = $this->client->delete($this->getFormattedRequestUrlWithParams());
                break;
            default:
                throw new Exception(sprintf('The HTTP method "%s" isn\'t supported', $method));
                break;
        }

        try {
            $this->response = $request->send();
        } catch (Exception $e) {
            $this->response = $e->getResponse();
        }
    }

    /**
     * @Given /^the type of the "([^"]*)" property is ([^"]*)$/
     */
    public function theTypeOfThePropertyIsNumeric($propertyName, $typeString)
    {
        $data = json_decode($this->response->getBody(true));

        if (!empty($data)) {
            if (!isset($data->$propertyName)) {
                throw new Exception("Property '".$propertyName."' is not set!\n");
            }
            // check our type
            switch (strtolower($typeString)) {
                case 'numeric':
                    if (!is_numeric($data->$propertyName)) {
                        throw new Exception("Property '".$propertyName."' is not of the correct type: ".$theTypeOfThePropertyIsNumeric."!\n");
                    }
                    break;
            }

        } else {
            throw new Exception("Response was not JSON\n" . $this->response->getBody(true));
        }
    }

    /**
     * @Then /^echo last response$/
     */
    public function echoLastResponse()
    {
        $this->printDebug(
            $this->requestUrl."\n\n".
            $this->response
        );
    }

    /**
     * @param string $format
     *
     * @return array
     */
    public function getResponseBody($format = 'json')
    {
        if (null === $this->responseBody) {
            if ($format == 'json') {
                $this->responseBody = json_decode($this->response->getBody(true));
            }
        }

        return $this->responseBody;
    }

    /**
     * @Then /^the response should be JSON$/
     */
    public function theResponseShouldBeJson()
    {
        $data = $this->getResponseBody();
        if (empty($data)) {
            throw new Exception("Response was not JSON\n" . $this->response/*$this->response->getBody(true)*/);
        }
    }

    /**
     * @Then /^the response status code should be (\d+)$/
     */
    public function theResponseStatusCodeShouldBe($httpStatus)
    {
        if ((string) $this->response->getStatusCode() !== $httpStatus) {
            throw new Exception('HTTP code does not match "'.$httpStatus.'" (actual: "'.$this->response->getStatusCode().'")');
        }
    }

    /**
     * @Then /^the response reasonPhrase should be "([^"]*)"$/
     */
    public function theResponseReasonPhraseShouldBe($reasonPhrase)
    {
        if ((string) $this->response->getReasonPhrase() !== $reasonPhrase) {
            throw new Exception('HTTP reason phrase does not match "'.$reasonPhrase.'" (actual: "'.$this->response->getReasonPhrase().'")');
        }
    }

    /**
     * @Given /^the response has a "([^"]*)" property$/
     */
    public function theResponseHasAProperty($propertyName)
    {
        if (!isset($this->getResponseBody()->$propertyName)) {
            throw new Exception("Property '".$propertyName."' is not set!\n");
        }
    }

    /**
     * @Then /^the "([^"]*)" property equals "([^"]*)"$/
     */
    public function thePropertyEquals($propertyName, $propertyValue)
    {
        $data = $this->getResponseBody();

        $this->theResponseHasAProperty($propertyName);

        if ($data->$propertyName != $propertyValue) {
            throw new Exception('Property value mismatch! (given: "'.$propertyValue.'", match: "'.$data->$propertyName.'")');
        }
    }
}

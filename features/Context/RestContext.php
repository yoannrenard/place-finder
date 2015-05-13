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
    /** @var \Guzzle\Http\ClientInterface */
    protected $client;

    /** @var \Guzzle\Http\Message\Response */
    protected $response;

    /** @var array */
    protected $parameters;

    /** @var array */
    protected $responseBody;

    /**
     * Construct
     *
     * @param array           $parameters
     * @param ClientInterface $client
     */
    public function __construct(array $parameters, ClientInterface $client)
    {
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

    /**
     * @param string $objectType
     *
     * @return string
     */
    protected function getRestObjectFromObjectType($objectType)
    {
        return sprintf('%ss', strtolower($objectType));
    }

    /**
     * @param string $objectType
     * @param int    $id
     *
     * @Given /^that I want to find the "([^"]*)" identified by "([^"]*)"$/
     */
    public function thatIWantToFindTheIdentifiedBy($objectType, $id)
    {
        $this->iRequest(sprintf('%s/%d', $this->getRestObjectFromObjectType($objectType), $id), 'GET');
    }

    /**
     * @param string    $objectType
     * @param TableNode $table
     *
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
//        $this->iRequest(sprintf('%s', $this->getRestObjectFromObjectType($objectType)), 'POST');
//    }
//
//    /**
//     * @Given /^that I want to delete the "([^"]*) identified by "([^"]*)"$/
//     */
//    public function thatIWantToDeleteA($objectType)
//    {
//        $this->iRequest(sprintf('%s/%d', $this->getRestObjectFromObjectType($objectType), $id), 'DELETE');
//    }

    /**
     * @param string $requestUrl
     * @param array  $paramList
     *
     * @return string
     */
    protected function getFormattedRequestUrlWithParams($requestUrl, array $paramList = array())
    {
        if (!empty($this->restObject)) {
            return $requestUrl.'?'.http_build_query((array) $this->restObject);
        }

        return $requestUrl;
    }

    /**
     * @param string $requestUrl
     * @param string $method
     * @param array  $paramList
     *
     * @throws \Exception
     *
     * @When /^I request "([^"]*)"$/
     */
    public function iRequest($requestUrl, $method = 'GET', array $paramList = array())
    {
        switch ($method) {
            case 'GET':
                $request = $this->client->get($this->getFormattedRequestUrlWithParams($requestUrl, $paramList));
                break;
            case 'POST':
                $request = $this->client->post($this->getFormattedRequestUrlWithParams($requestUrl), null, (array) $paramList);
                break;
            case 'DELETE':
                $request = $this->client->delete($this->getFormattedRequestUrlWithParams($requestUrl, $paramList));
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
     * @param string $propertyName
     * @param string $typeString
     *
     * @throws \Exception
     *
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

//    /**
//     * @Then /^echo last response$/
//     */
//    public function echoLastResponse()
//    {
//        $this->printDebug(
//            $this->requestUrl."\n\n".
//            $this->response
//        );
//    }

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
     * @throws \Exception
     *
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
     * @param int $httpStatus
     *
     * @throws \Exception
     *
     * @Then /^the response status code should be (\d+)$/
     */
    public function theResponseStatusCodeShouldBe($httpStatus)
    {
        if ((string) $this->response->getStatusCode() !== $httpStatus) {
            throw new Exception('HTTP code does not match "'.$httpStatus.'" (actual: "'.$this->response->getStatusCode().'")');
        }
    }

    /**
     * @param string $reasonPhrase
     *
     * @throws \Exception
     *
     * @Then /^the response reasonPhrase should be "([^"]*)"$/
     */
    public function theResponseReasonPhraseShouldBe($reasonPhrase)
    {
        if ((string) $this->response->getReasonPhrase() !== $reasonPhrase) {
            throw new Exception('HTTP reason phrase does not match "'.$reasonPhrase.'" (actual: "'.$this->response->getReasonPhrase().'")');
        }
    }

    /**
     * @param string $propertyName
     *
     * @throws \Exception
     *
     * @Given /^the response has a "([^"]*)" property$/
     */
    public function theResponseHasAProperty($propertyName)
    {
        if (!isset($this->getResponseBody()->$propertyName)) {
            throw new Exception("Property '".$propertyName."' is not set!\n");
        }
    }

    /**
     * @param string $propertyName
     * @param string $propertyValue
     *
     * @throws \Exception
     *
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

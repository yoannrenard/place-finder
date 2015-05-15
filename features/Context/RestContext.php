<?php

namespace Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Exception;
use Guzzle\Http\ClientInterface;
use Guzzle\Http\Message\RequestInterface;
use PHPUnit_Framework_Assert as Assertions;

/**
 * Class RestContext
 *
 * @package Context
 *
 * todo Allow other format than json, xml, ...
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
        $this->iSendARequestTo(RequestInterface::GET, sprintf('%s/%d', $this->getRestObjectFromObjectType($objectType), $id));
    }

    /**
     * @param string    $objectType
     * @param TableNode $paramTable
     *
     * @Given /^that I want to find a "([^"]*)" with:$/
     */
    public function thatIWantToFindA($objectType, TableNode $paramTable)
    {
        $this->iSendARequestTo(RequestInterface::GET, sprintf('%s', $this->getRestObjectFromObjectType($objectType)), $paramTable);
    }

//    /**
//     * @Given /^that I want to make a new "([^"]*)"$/
//     */
//    public function thatIWantToMakeANew($objectType)
//    {
//        $this->iSendARequestTo(RequestInterface::POST, sprintf('%s', $this->getRestObjectFromObjectType($objectType)));
//    }
//
//    /**
//     * @Given /^that I want to delete the "([^"]*) identified by "([^"]*)"$/
//     */
//    public function thatIWantToDeleteA($objectType)
//    {
//        $this->iSendARequestTo(RequestInterface::DELETE, sprintf('%s/%d', $this->getRestObjectFromObjectType($objectType), $id));
//    }

    /**
     * @param string $requestUrl
     * @param array  $paramList
     *
     * @return string
     */
    protected function getFormattedRequestUrlWithParamList($requestUrl, array $paramList = array())
    {
        if (!empty($paramList)) {
            return sprintf('%s?%s', $requestUrl, http_build_query($paramList));
        }

        return $requestUrl;
    }

    /**
     * @param string    $method
     * @param string    $requestUrl
     * @param TableNode $paramTable
     *
     * @throws \Exception
     *
     * @Given /^I send a (GET|POST|DELETE) request to "([^"]*)"$/
     * @Given /^I send a (GET|POST|DELETE) request to "([^"]*)" with:$/
     */
    public function iSendARequestTo($method, $requestUrl, TableNode $paramTable = null)
    {
        // Extract params
        $paramList = array();
        if ($paramTable) {
            foreach ($paramTable->getHash() as $mapping) {
                $paramList[$mapping['Field']] = $mapping['Value'];
            }
        }

        switch ($method) {
            case RequestInterface::GET:
                $request = $this->client->get($this->getFormattedRequestUrlWithParamList($requestUrl, $paramList));
                break;
            case RequestInterface::POST:
                $request = $this->client->post($this->getFormattedRequestUrlWithParamList($requestUrl), null, $paramList);
                break;
            case RequestInterface::DELETE:
                $request = $this->client->delete($this->getFormattedRequestUrlWithParamList($requestUrl, $paramList));
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

//    /**
//     * @param string $propertyName
//     * @param string $typeString
//     *
//     * @throws \Exception
//     *
//     * @Given /^the type of the "([^"]*)" property is ([^"]*)$/
//     */
//    public function theTypeOfThePropertyIsNumeric($propertyName, $typeString)
//    {
//        $data = json_decode($this->response->getBody(true));
//
//        if (!empty($data)) {
//            if (!isset($data->$propertyName)) {
//                throw new Exception("Property '".$propertyName."' is not set!\n");
//            }
//            // check our type
//            switch (strtolower($typeString)) {
//                case 'numeric':
//                    if (!is_numeric($data->$propertyName)) {
//                        throw new Exception("Property '".$propertyName."' is not of the correct type: ".$theTypeOfThePropertyIsNumeric."!\n");
//                    }
//                    break;
//            }
//        } else {
//            throw new Exception("Response was not JSON\n" . $this->response->getBody(true));
//        }
//    }

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
        $data = $this->getResponseBody('json');
        if (!is_array($data) && empty($data)) {
            throw new Exception(sprintf("Response was not JSON:%s%s", PHP_EOL, $this->response->getBody(true)));
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
        Assertions::assertSame((int) $httpStatus, $this->response->getStatusCode());
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
        Assertions::assertSame($reasonPhrase, $this->response->getReasonPhrase());
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
        Assertions::assertTrue(isset($this->getResponseBody()->$propertyName));
    }

    /**
     * @param string $propertyName
     * @param string $propertyValue
     *
     * @throws \Exception
     *
     * @Then /^the "([^"]*)" property equals ([^"]*)$/
     * @Then /^the "([^"]*)" property equals "([^"]*)"$/
     */
    public function thePropertyEquals($propertyName, $propertyValue)
    {
        $data = $this->getResponseBody();

        $this->theResponseHasAProperty($propertyName);

        switch (gettype($data->$propertyName)) {
            case 'boolean':
                if (true === $data->$propertyName) {
                    Assertions::assertTrue($propertyValue);
                } else {
                    Assertions::assertTrue('false' == $propertyValue || 0 == $propertyValue);
                }
                break;
            default:
                Assertions::assertEquals($propertyValue, $data->$propertyName);
                break;
        }
    }

    /**
     * @Given /^the response should contains (\d+) results$/
     */
    public function theResponseShouldContainsResults($nbResult)
    {
        Assertions::assertTrue(is_array($this->getResponseBody()));
        Assertions::assertEquals($nbResult, count($this->getResponseBody()));
    }
}

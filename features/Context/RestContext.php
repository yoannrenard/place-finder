<?php

namespace Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\PyStringNode;
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
     * @param TableNode $paramTableNode
     *
     * @Given /^that I want to find a "([^"]*)" with:$/
     */
    public function thatIWantToFindA($objectType, TableNode $paramTableNode)
    {
        // Extract params
        $paramList = array();
        if ($paramTableNode) {
            foreach ($paramTableNode->getHash() as $mapping) {
                $paramList[$mapping['Field']] = $mapping['Value'];
            }
        }

        $this->iSendARequestTo(RequestInterface::GET, sprintf('%s', $this->getRestObjectFromObjectType($objectType)), $paramList);
    }

    /**
     * @Given /^that I want to create a new "([^"]*)" with json:$/
     */
    public function thatIWantToCreateANewWithJson($objectType, PyStringNode $string)
    {
        $this->iSendARequestTo(RequestInterface::POST, sprintf('%s', $this->getRestObjectFromObjectType($objectType)), $string->getRaw());
    }

    /**
     * @Given /^that I want to update partially the "([^"]*)" identified by "([^"]*)" with json:$/
     */
    public function thatIWantToUpdatePartiallyTheIdentifiedByWithJson($objectType, $id, PyStringNode $string)
    {
        $this->iSendARequestTo(RequestInterface::PATCH, sprintf('%s', sprintf('%s/%d', $this->getRestObjectFromObjectType($objectType), $id)), json_decode($string->getRaw(), true));
    }

    /**
     * @Given /^that I want to update the "([^"]*)" identified by "([^"]*)" with json:$/
     */
    public function thatIWantToUpdateTheIdentifiedByWithJson($objectType, $id, PyStringNode $string)
    {
        $this->iSendARequestTo(RequestInterface::PUT, sprintf('%s', $this->getRestObjectFromObjectType($objectType)), json_decode($string->getRaw(), true));
    }

    /**
     * @Given /^that I want to delete the "([^"]*)" identified by "([^"]*)"$/
     */
    public function thatIWantToDeleteTheIdentifiedBy($objectType, $id)
    {
        $this->iSendARequestTo(RequestInterface::DELETE, sprintf('%s/%d', $this->getRestObjectFromObjectType($objectType), $id));
    }

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
     * @param string $method
     * @param string $requestUrl
     * @param mixed  $body
     * @param array  $paramList
     *
     * @throws \Exception
     *
     * @Given /^I send a (GET|POST|DELETE) request to "([^"]*)"$/
     */
    public function iSendARequestTo($method, $requestUrl, $body = null, array $paramList = array())
    {
        $paramList['_format'] = 'json';

        $headers = array(
            'Content-Type' => 'application/json',
        );

        switch ($method) {
            case RequestInterface::GET:
                $request = $this->client->get($this->getFormattedRequestUrlWithParamList($requestUrl, $paramList));
                break;
            case RequestInterface::POST:
                $request = $this->client->post($this->getFormattedRequestUrlWithParamList($requestUrl), $headers, $body, $paramList);
                break;
            case RequestInterface::PUT:
                $request = $this->client->put($this->getFormattedRequestUrlWithParamList($requestUrl), $headers, $body, $paramList);
                break;
            case RequestInterface::PATCH:
                $request = $this->client->patch($this->getFormattedRequestUrlWithParamList($requestUrl), $headers, $body, $paramList);
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
        Assertions::assertSame('application/json', (string) $this->response->getHeader('content-type'));

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
            case 'bool':
                if (true === $data->$propertyName) {
                    Assertions::assertTrue(1 == $propertyValue || 'true' == $propertyValue);
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

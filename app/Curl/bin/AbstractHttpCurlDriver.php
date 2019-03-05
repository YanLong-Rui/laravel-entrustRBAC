<?php
/**
 * Created by PhpStorm.
 * User: RYL
 * Date: 2019/2/19
 * Time: 10:04
 */

namespace App\Curl\bin;

use GuzzleHttp\Client;

abstract class AbstractHttpCurlDriver implements CurlInterfaceDriver
{
    /**
     * @var null|Client
     */
    protected $client = null;

    protected $response = null;

    public function __construct(Client $client = null)
    {
        if (is_null($client)) {
            $client = new Client();
        }

        $this->setClient($client);
    }

    /**
     * @param $url
     * @param array $options
     * @return string
     * @date 2019/01/25
     * @author ycz
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($url, $options = [])
    {
        $response = $this->getClient()->request('GET', $url, $options)->getBody()->getContents();

        $this->setResponse($response);

        return $response;
    }

    /**
     * @param $url
     * @param array $options
     * @return string
     * @date 2019/01/25
     * @author ycz
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($url, $options = [])
    {
        $response = $this->getClient()->request('POST', $url, $options)->getBody()->getContents();

        $this->setResponse($response);

        return $response;
    }

    /**
     * @param $method
     * @param $url
     * @param array $options
     * @return string
     * @date 2019/01/25
     * @author ycz
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $url, $options = [])
    {
        $response = $this->getClient()->request($method, $url, $options)->getBody()->getContents();

        $this->setResponse($response);

        return $response;
    }

    /**
     * @return null|Client
     */
    private function getClient()
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    private function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return null|string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param null|string $response
     */
    private function setResponse($response)
    {
        $this->response = $response;
    }
}
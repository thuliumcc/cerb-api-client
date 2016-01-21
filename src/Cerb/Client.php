<?php
namespace Cerb;

use Cerb\Model\Ticket;
use stdClass;

class Client
{
    /**
     * @var string
     */
    private $uri;
    /**
     * @var string
     */
    private $accessKey;
    /**
     * @var string
     */
    private $secretKey;
    /**
     * @var CurlCaller
     */
    private $curlCaller;

    /**
     * @param string $uri
     * @param string $accessKey
     * @param string $secretKey
     * @param null|CurlCaller $curlCaller
     */
    public function __construct($uri, $accessKey, $secretKey, CurlCaller $curlCaller = null)
    {
        $this->uri = rtrim($uri, '/');
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
        $this->curlCaller = $curlCaller ?: new CurlCaller($this->uri, $this->accessKey, $this->secretKey);
    }

    /**
     * @param string $resource
     * @return stdClass
     */
    public function get($resource)
    {
        return $this->call('GET', $resource);
    }

    /**
     * @param string $resource
     * @param null|array|string $payload
     * @return stdClass
     */
    public function put($resource, $payload = null)
    {
        return $this->call('PUT', $resource, $payload);
    }

    /**
     * @param string $resource
     * @param null|array|string $payload
     * @return stdClass
     */
    public function post($resource, $payload = null)
    {
        return $this->call('POST', $resource, $payload);
    }

    /**
     * @param string $resource
     * @return stdClass
     */
    public function delete($resource)
    {
        return $this->call('DELETE', $resource);
    }

    /**
     * @param string $verb
     * @param string $resource
     * @param null|array|string $payload
     * @return stdClass
     */
    public function call($verb, $resource, $payload = null)
    {
        return $this->curlCaller->call($verb, $resource, $payload);
    }

    /**
     * @param array|string $where
     * @return Ticket[]
     */
    public function getTickets($where)
    {
        $result = $this->post('/tickets/search.json', $where);
        return Ticket::convertToModels($result);
    }

    /**
     * @param int $id
     * @return Ticket
     */
    public function getTicket($id)
    {
        $result = $this->get('/tickets/' . $id . '.json');
        return Ticket::convertToModel($result);
    }
}

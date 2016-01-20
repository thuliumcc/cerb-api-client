<?php
namespace Cerb;

use Cerb\Model\Ticket;

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

    public function __construct($uri, $accessKey, $secretKey, $curlCaller = null)
    {
        $this->uri = rtrim($uri, '/');
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
        $this->curlCaller = $curlCaller ?: new CurlCaller($this->uri, $this->accessKey, $this->secretKey);
    }

    public function get($url)
    {
        return $this->call('GET', $url);
    }

    public function put($url, $payload = null)
    {
        return $this->call('PUT', $url, $payload);
    }

    public function post($url, $payload = null)
    {
        return $this->call('POST', $url, $payload);
    }

    public function delete($url)
    {
        return $this->call('DELETE', $url);
    }

    public function call($verb, $resource, $payload = null)
    {
        return $this->curlCaller->call($verb, $resource, $payload);
    }

    /**
     * @param $where
     * @return Ticket[]
     */
    public function getTickets($where)
    {
        $result = $this->post('/tickets/search.json', $where);
        return Ticket::convertToModels($result);
    }

    /**
     * @param $id
     * @return Ticket
     */
    public function getTicket($id)
    {
        $result = $this->get('/tickets/' . $id . '.json');
        return Ticket::convertToModel($result);
    }
}

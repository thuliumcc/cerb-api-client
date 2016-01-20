<?php
namespace Cerb;

class CurlCaller
{
    private $uri;
    private $accessKey;
    private $secretKey;

    public function __construct($uri, $accessKey, $secretKey)
    {
        $this->uri = $uri;
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
    }

    public function call($verb, $resource, $payload)
    {
        $baseUrl = $this->uri . '/' . ltrim($resource, '/');
        $verb = strtoupper($verb);
        $date = date(DATE_RFC2822);
        $postfields = ParametersPreparer::postfields($payload);
        $urlParts = parse_url($baseUrl);
        $urlPath = $urlParts['path'];
        $urlQuery = '';
        if (!empty($urlParts['query'])) {
            $urlQuery = ParametersPreparer::sortedUrlQueryString($urlParts['query']);
        }
        $secret = md5($this->secretKey);
        $signature = md5("$verb\n$date\n$urlPath\n$urlQuery\n$postfields\n$secret\n");

        $headers[] = 'Date: ' . $date;
        $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
        $headers[] = 'Cerb-Auth: ' . sprintf("%s:%s", $this->accessKey, $signature);

        $curl = curl_init();
        switch ($verb) {
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'PUT':
                $headers[] = 'Content-Length: ' . strlen($postfields);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
                break;
            case 'POST':
                $headers[] = 'Content-Length: ' . strlen($postfields);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postfields);
                break;
        }
        curl_setopt($curl, CURLOPT_URL, $baseUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $output = json_decode(curl_exec($curl));
        curl_close($curl);
        ErrorHandler::handle($output);
        return $output;
    }
}

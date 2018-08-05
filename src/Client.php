<?php

namespace ConvertLoop;

class Client
{
    private $appId;

    private $apiKey;

    private $baseUrl = 'https://api.convertloop.co/';

    private $version = 'v1';

    private $httpExecutor;

    public function __construct($appId, $apiKey, $version) {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
        $this->version = $version;
        $this->httpExecutor = new HttpExecutor();
    }

    public function post($resource, $data) {
        $request = $this->buildRequest($resource, "POST", $data);
        return $this->httpExecutor->execute($request);
    }

    public function get($resource, $data = '{}') {
        $request = $this->buildRequest($resource, "GET", $data);
        return $this->httpExecutor->execute($request);
    }

    public function delete($resource, $data = '{}') {
        $request = $this->buildRequest($resource, "DELETE", $data);
        return $this->httpExecutor->execute($request);
    }

    public function setBaseUrl($baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    public function setHttpExecutor($httpExecutor) {
      $this->httpExecutor = $httpExecutor;
    }

    private function buildRequest($resource, $method, $data) {
        $data_string = json_encode($data);
        $url = $this->baseUrl . $this->version . $resource;
        $request = array("url" => $url, "method" => $method, "body" => $data_string);
        $auth_string = $this->appId . ":" . $this->apiKey;
        $auth = base64_encode($auth_string);
        $request["headers"] = array(
            "Authorization" => "Basic " . $auth,
            "Content-Type" => "application/json",
            "Content-Length" => strlen($data_string)
            );
        return $request;
    }
}

?>

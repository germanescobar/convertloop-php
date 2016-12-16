<?php

namespace ConvertLoop;

class ConvertLoop
{
    private $client;

    public function __construct($appId, $apiKey, $version) {
        $this->client = new Client($appId, $apiKey, $version);
    }

    public function people() {
        return new People($this->client);
    }

    public function eventLogs() {
        return new EventLogs($this->client);
    }

    public function setBaseUrl($baseUrl) {
      $this->client->setBaseUrl($baseUrl);
    }
}

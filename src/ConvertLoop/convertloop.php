<?php

namespace ConvertLoop;

class ConvertLoop
{
    private $client;

    public function __construct($appId, $apiKey, $data = '') {
        $this->client = new Client($appId, $apiKey);
    }

    public function people() {
        return new People($this->client);
    }

    public function eventLogs() {

    }
}

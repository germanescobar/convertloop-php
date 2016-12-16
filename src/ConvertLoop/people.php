<?php

namespace ConvertLoop;

class People
{
    private $client;

    public function __construct($client) {
        $this->client = $client;
    }

    public function createOrUpdate($data) {
        return $this->client->post("/people", $data);
    }
}

?>

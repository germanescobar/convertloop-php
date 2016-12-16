<?php

namespace ConvertLoop;

class EventLogs
{
    private $client;

    public function __construct($client) {
        $this->client = $client;
    }

    public function send($data) {
        return $this->client->post("/event_logs", $data);
    }
}

?>

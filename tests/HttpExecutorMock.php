<?php

namespace ConvertLoop;

class HttpExecutorMock
{
    public $lastRequest;

    private $response;

    public $numCalls;

    public function __construct($response) {
        $this->numCalls = 0;
        $this->$response = $response;
    }

    public function execute($request) {
        $this->numCalls++;
        $this->lastRequest = $request;

        return json_decode($this->response);
    }

    private function isValidRequest($request) {
        return $this->isValidURL($request["url"])
                && $this->isValidMethod($request["method"])
                && $this->areValidHeaders($request["headers"])
                && $this->isValidBody($request["body"]);
    }

    private function isValidURL($URL) {
        $result = $this->expectedRequest["url"] == $URL;
        if (!$result) {
            throw new Exception("\nInvalid URL - Expected : " . $this->expectedRequest["url"] . "  URL : " . $URL);
        }
        return $result;
    }

    private function isValidMethod($method) {
        $result = $this->expectedRequest["method"] == $method;
        if (!$result) {
            throw new Exception("\nInvalid Method - Expected : " . $this->expectedRequest["method"] . "  Method : " . $method);
        }
        return $result;
    }

    private function areValidHeaders($headers) {
        if (array_key_exists("headers", $this->expectedRequest)) {
            foreach ($this->expectedRequest["headers"] as $key => $value) {
                if ($headers[$key] != $value) {
                    throw new Exception("\nInvalid Headers - Expected : " . json_encode($this->expectedRequest["headers"]) . " Headers : " . json_encode($headers));
                    return false;
                }
            }
        }
        return true;
    }

    private function isValidBody($body) {
        $result = $this->expectedRequest["body"] == $body;
        if (!$result) {
            throw new Exception("\nInvalid Body - Expected : " . $this->expectedRequest["body"] . " Body : " . $body);
        }
        return $result;
    }
}

?>

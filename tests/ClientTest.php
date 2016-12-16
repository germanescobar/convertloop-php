<?php

namespace ConvertLoop;

class ClientTest extends TestCase
{
    public function testPostRequest() {
        $mockExecutor = new HttpExecutorMock("{}");

        $client = new Client("app_id", "api_key", "v1");
        $client->setHttpExecutor($mockExecutor);

        $response = $client->post("/people", array("email" => "test@example.com"));
        $this->assertEquals(1, $mockExecutor->numCalls);

        $this->assertEquals("https://api.convertloop.co/v1/people", $mockExecutor->lastRequest["url"]);
        $this->assertEquals("POST", $mockExecutor->lastRequest["method"]);
        $this->assertEquals("Basic YXBwX2lkOmFwaV9rZXk=", $mockExecutor->lastRequest["headers"]["Authorization"]);
    }
}

?>

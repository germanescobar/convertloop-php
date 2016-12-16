<?php

namespace ConvertLoop;

class HttpExecutor
{
    public function __construct() {
    }

    public function execute($request) {
        $handler = curl_init($request["url"]);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, $request["method"]);
        curl_setopt($handler, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($handler, CURLOPT_VERBOSE, true);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);

        $headers = $this->parseHeaders($request["headers"]);
        curl_setopt($handler, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $request["body"]);

        $response = curl_exec($handler);
        $code = curl_getinfo($handler, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            $errorMessage = $this->getErrorMessage($handler, $request["url"]);
            throw new \Exception($errorMessage);
        }

        return json_decode(utf8_encode($response));
    }

    private function parseHeaders($arrayHeaders) {
        $headers = array();
        foreach ($arrayHeaders as $key => $value) {
            array_push($headers, $key . ": " . $value);
        }
        return $headers;
    }

    private function getErrorMessage($handler, $url) {
        $code = curl_getinfo($handler, CURLINFO_HTTP_CODE);
        $error_description = curl_error($handler);
        switch($code) {
            case 0 : {
                return 'Server not found, check your internet connection or proxy configuration. [' . $error_description . ']';
            }
            case 401 : {
                return 'Unauthorized resource [' . $url . ']. Check your user credentials';
            }
            default : {
                return 'Unexpected error [' . $url . '] [code=' . $code . ']';
            }
        }
    }
}

?>

<?php

namespace Pagomio;


class Client {

    const BASE_URL_SANDBOX = "https://sandbox.pagomio.com/api/v1/payment";
    const BASE_URL_PROD = "https://www.pagomio.com/api/v1/payment";

    protected $base_url;

    protected function request($method, $url, $client_id, $secret_id, $data = NULL, $headers= array("Content-Type" => "application/json", "Accept" => "application/json") ) {

        try {
            $options = array(
                'auth' => new \Requests_Auth_Basic(array($client_id, $secret_id))
            );

            if($method == "GET") {
                $url_params = is_array($data) ? '?' . http_build_query($data) : '';
                $response = \Requests::get($this->base_url . $url . $url_params, $headers, $options);
            } else if($method == "POST") {
                $response = \Requests::post($this->base_url . $url, $headers, json_encode($data), $options);
            } else if($method == "PATCH") {
                $response = \Requests::patch($this->base_url . $url, $headers, json_encode($data), $options);
            } else if($method == "DELETE") {
                $response = \Requests::delete($this->base_url . $url, $headers, $options);
            }
        } catch (\Exception $e) {
            throw new \Exception(Error_Message::ERROR_CONNECTION);
        }

        if ($response->status_code >= 200 && $response->status_code <= 206) {
            if ($method == "DELETE") {
                return $response->status_code == 204 || $response->status_code == 200;
            }
            return json_decode($response->body);
        }

        if ($response->status_code >= 400 && $response->status_code <= 406) {
            try {
                $error = (array) json_decode($response->body);
                $code = $error['errorCode'];
                $message = $error['errorMessage'];
            } catch (\Exception $e) {
                throw new \Exception($response->body, $response->status_code);
            }
            throw new \Exception($message, $code);
        }
        throw new \Exception($response->body, $response->status_code);
    }
}

class Error_Message {
    const ERROR_SECRET_ID = "client_id and secret_id are required.";
    const ERROR_CONNECTION = "Connection error.";
    const ERROR_NOT_REQUEST = "Not request.";
    const ERROR_INVALID_REQUEST = "Request invalid.";
}
?>


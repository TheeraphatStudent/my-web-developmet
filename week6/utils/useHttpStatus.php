<?php

interface StatusProps {}

interface MessageProps {}

class HttpStatusResponse implements StatusProps, MessageProps
{
    private $statusCode;
    private $message;
    private $data;

    public function __construct($statusCode, $message, $data = null)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->data = $data;
    }

    public function send()
    {
        if (!headers_sent()) {
            http_response_code($this->statusCode);
        }

        $response = [
            'status' => $this->statusCode,
            'message' => $this->message
        ];

        if ($this->data !== null) {
            $response['data'] = $this->data;
        }

        echo json_encode($response);
    }

    public function getResponse()
    {
        $response = [
            'status' => $this->statusCode,
            'message' => $this->message
        ];

        if ($this->data !== null) {
            $response['data'] = $this->data;
        }

        return $response;
    }
}

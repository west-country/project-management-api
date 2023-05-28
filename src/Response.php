<?php

namespace ProjectManagementApi;

use JsonSerializable;

class Response implements JsonSerializable
{
    private string $message;
    private array|object $data; //private array $data

    public function __construct(string $message, array|object $data = []) //array $data
    {
        $this->message = $message;
        $this->data = $data;
    }

    public function issueResponse(int $code): void
    {
        http_response_code($code);
        $response = json_encode($this, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($code == 200) {
            echo $response;
        } else {
            exit($response);
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}

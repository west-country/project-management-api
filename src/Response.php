<?php

namespace ProjectManagementApi;

use JsonSerializable;

class Response implements JsonSerializable
{
    private string $message;
    private array $data;

    public function __construct(string $message, array $data)
    {
        $this->message = $message;
        $this->data = $data;
    }

    public function jsonSerialize()
    {
        return [
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
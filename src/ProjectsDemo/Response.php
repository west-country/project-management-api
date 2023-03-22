<?php

namespace ProjectManagementApi\ProjectsDemo;
use JsonSerializable;

class Response implements JsonSerializable {
    
    private array $data;
    private string $message;

    public function __construct($message, $data) {
        $this->data = $data;
        $this->message = $message;
    }

    public function jsonSerialize() {
        return [
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}

<?php

namespace ProjectManagementApi\ProjectsDemo;

use JsonSerializable;

class Response implements JsonSerializable {
    public function __constructor($message, $data) {}

    public function jsonSerialize(): mixed {
        return [
            'message' => 'Successfully retrieved projects',
            'data' => [
                [
                    "id" => "17",
                    "name" => "Overhold",
                    "client_id" => "7",
                    "deadline" => "30/06/2022", // "06-30-2022" if locale=us
                    "overdue" => true
                ],
                [
                    "id" => "18",
                    "name" => "Wrapsafe",
                    "client_id" => "18",
                    "deadline" => "28/03/2024",
                    "overdue" => false
                ]
            ]
        ];
    }
}

<?php

namespace ProjectManagementApi\Exceptions;

use Exception;
use ProjectManagementApi\Response;

class InvalidParameterException extends Exception
{
    public function issueUserResponse(): void
    {
        $response = new Response($this->message);
        $response->issueResponse(400);
    }
}

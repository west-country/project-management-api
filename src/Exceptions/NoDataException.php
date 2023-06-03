<?php

namespace ProjectManagementApi\Exceptions;

use Exception;
use ProjectManagementApi\Response;

class NoDataException extends Exception 
{ 
    public function issueUserResponse(): void
    {
        $response = new Response($this->message);
        $response->issueResponse(404);
    }
}